---
title: config.php
description: The settings ITFlow keeps in config.php - the database connection, its address, HTTPS, the update branch and the backup key - and what to add behind a reverse proxy or Cloudflare.
access: Server admins
---

`config.php`, in ITFlow's folder, holds what ITFlow needs before it can read its own settings from the database. Setup writes it. Change it with a text editor on the server. Everything else is set in [Admin > Settings](/admin/settings).

`config.php` holds the database password, so keep it readable only by the web server's user. Keep a copy somewhere safe, too.

## What's in it

| Setting | What it's for |
|---|---|
| `$dbhost`, `$dbusername`, `$dbpassword`, `$database` | The database connection |
| `$config_base_url` | ITFlow's address, without `https://`, such as `itflow.example.com`. Links in emails, the client portal and shared links use it. Change it when the address changes. |
| `$config_https_only` | `TRUE` lets people sign in over HTTPS only, and keeps sign-in cookies off plain http://. Set it to `FALSE` only for a test install that stays on your own network. |
| `$repo_branch` | The branch updates come from: `master`, the released versions, or `develop`, for testing |
| `$config_app_name` | The name in authenticator apps and in some notification emails. Normally `ITFlow`. |
| `$installation_id` | A random id made at setup. It's sent with the install details if you choose to share them with the ITFlow project. |
| `$config_enable_setup` | Setup adds `$config_enable_setup = 0;` when it finishes, which closes the setup wizard. |
| `$config_backup_key` | The key backups are locked with. ITFlow adds it the first time it needs it. Copy it somewhere safe, away from the server. If you ever change it, keep the old key too, because older backups still need it. |

## Behind a reverse proxy or Cloudflare {#proxy}

When ITFlow sits behind a reverse proxy, such as nginx, HAProxy, a firewall's web proxy or Cloudflare, two things need setting.

**HTTPS.** If the proxy handles the certificate and talks to ITFlow over plain http, it must send the `X-Forwarded-Proto: https` header. ITFlow then knows the visitor came over HTTPS and lets them sign in. Cloudflare sends it already. With nginx as the proxy, add these to its `location` block:

```nginx
proxy_set_header X-Forwarded-Proto $scheme;
proxy_set_header X-Forwarded-For $remote_addr;
```

Use `$remote_addr` rather than nginx's usual `$proxy_add_x_forwarded_for`. ITFlow reads the first address in the header, and `$proxy_add_x_forwarded_for` keeps whatever address the visitor sent first.

**Visitors' addresses.** ITFlow records where each request came from, in the audit log and sign-in history. It also uses the address to block an address after repeated failed sign-ins. Behind a proxy, every request seems to come from the proxy. To have ITFlow use the address the proxy passes on, add one of these lines to `config.php`:

```php
// Behind a reverse proxy that sets X-Forwarded-For
define('CONST_GET_IP_METHOD', 'HTTP_X_FORWARDED_FOR');

// Behind Cloudflare
define('CONST_GET_IP_METHOD', 'HTTP_CF_CONNECTING_IP');
```

> [!WARNING]
> Add this only when every request reaches ITFlow through the proxy. Anyone can put an address in these headers. ITFlow trusts them only because the line says your proxy sets them. With `HTTP_X_FORWARDED_FOR`, ITFlow turns away any request that comes straight to it without the header. If people in your office reach ITFlow directly, point the name at the proxy for them as well, with split DNS on your network.
