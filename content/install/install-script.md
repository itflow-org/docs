---
title: Install with the script
description: One command on a fresh Debian 13 server installs Apache, MariaDB, PHP and ITFlow, gets a certificate, adds cron and leaves you at the setup wizard.
---

The install script sets up everything ITFlow needs on a fresh Debian 13 server, then hands you to the setup wizard to make your account. It takes a few minutes.

> [!WARNING]
> Use a new server that runs nothing else. The script upgrades the server's packages, sets up Apache, and turns off Apache's default site.

## Run it

1. Point your domain name, such as `itflow.example.com`, at the server's public IP address, and open ports 80 and 443 to it.
2. Sign in to the server as root.
3. Download the script and run it:
   ```
   wget -O itflow_install.sh https://github.com/itflow-org/itflow-install-script/raw/main/itflow_install.sh
   bash itflow_install.sh
   ```
4. Answer its four questions. Press <kbd>Enter</kbd> to take the suggestion in brackets:
   ```
   Timezone [UTC]: America/New_York
   Domain [debian]: itflow.example.com
   Available branches: master, develop
   Which branch to use [master]:
   SSL options: letsencrypt, selfsigned, none
   SSL type [letsencrypt]:
   ```
5. Wait for **Installation Complete!**, then open the address it shows, such as `https://itflow.example.com`. The setup wizard opens at [your account](/install/setup#your-account), because the script has already set up the database.

| Question | What to answer |
|---|---|
| **Timezone** | The server's timezone, such as `America/New_York` or `Europe/London`. You set ITFlow's own timezone in the setup wizard. |
| **Domain** | The full name ITFlow will be reached at. For a Let's Encrypt certificate, it must already point at this server. |
| **Branch** | `master`, the released versions. `develop` is where new work lands first, and is only for testing. |
| **SSL type** | `letsencrypt` gets a free certificate that renews by itself. `selfsigned` makes one that browsers warn about, for a test server. `none` leaves ITFlow on plain http://, and lets you sign in without HTTPS. Only use `none` on a test server that stays on your own network. |

## What it sets up

- Apache, MariaDB, PHP and the PHP extensions ITFlow uses, git, cron and certbot, after upgrading the packages already on the server
- PHP limits of 500 MB for uploads and 5 minutes for a page to run, so you can restore large backups
- An Apache site for your domain, with ITFlow in `/var/www/` followed by the domain, such as `/var/www/itflow.example.com`, owned by the web server's user, `www-data`
- The certificate: Let's Encrypt's, or a self-signed one
- A database and a database user, both called `itflow`, with a random password. It creates ITFlow's tables in the database and writes `config.php`.
- The [cron entry](/admin/maintenance#cron), in `/etc/cron.d/itflow`, run every minute as `www-data`

## Without the questions {#unattended}

To build servers without answering questions, give the answers as options and add `--unattended`:

```
bash itflow_install.sh --domain itflow.example.com --timezone America/New_York --ssl letsencrypt --unattended
```

| Option | Does |
|---|---|
| `-d`, `--domain` | The domain name. Without it, the server's own full name is used. |
| `-t`, `--timezone` | The server's timezone. Unattended, it is `America/New_York` unless you give one. |
| `-b`, `--branch` | `master` (the default) or `develop` |
| `-s`, `--ssl` | `letsencrypt` (the default), `selfsigned` or `none` |
| `-u`, `--unattended` | Ask nothing |
| `-h`, `--help` | List the options |

## If it doesn't work

- **Invalid domain.** - give a full name, such as `itflow.example.com`, not `itflow` on its own.
- **Invalid timezone.** - use a name from `timedatectl list-timezones`, such as `Europe/London`.
- **No certificate** - Let's Encrypt can't reach the server by its name. Check the name points at the server and port 80 is open, then get the certificate on its own: `certbot --apache -d itflow.example.com`. Until then, ITFlow won't let you sign in.
- The script prints what it is doing as it goes. Scroll back to see where it stopped, and see [When something goes wrong](/install/troubleshooting).

Once the setup wizard is done, sign in: Get started takes you through the rest. See [After installing](/install/after-install).
