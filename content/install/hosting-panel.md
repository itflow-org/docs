---
title: Install on a hosting panel
description: Put ITFlow on a server run with HestiaCP, cPanel, Plesk or Jabali - the site, PHP and its limits, the database, the files, cron, a certificate, and keeping its private folders private.
---

A hosting control panel can run ITFlow beside your other sites. The panel makes the site, the database and the certificate. You put ITFlow in the site's folder with git, raise PHP's limits and add one cron job, and the [setup wizard](/install/setup) does the rest.

The steps are much the same on every panel - only where you click differs. Each has its own section: [HestiaCP](#hestiacp), [cPanel](#cpanel), [Plesk](#plesk) and [Jabali](#jabali). Use your own domain wherever `itflow.example.com` appears, and your panel account's name wherever `summit` does.

> [!NOTE]
> Panels run PHP through PHP-FPM. Before ITFlow 26.11.9, that stopped your logo, avatars and photos from loading. If you install an earlier version, update it first.

## What ITFlow needs from the panel {#needs}

| Part | What to set up |
|---|---|
| **A site of its own** | A domain or subdomain, such as `itflow.example.com`, with ITFlow at its root - not in a folder of another site. |
| **PHP** | 8.2 or later, with the extensions in [Before you install](/install/requirements). Panels usually have them all, and the setup wizard says if one is missing. |
| **PHP's limits** | `upload_max_filesize` and `post_max_size` of `500M`, and `max_execution_time` of `300`, so you can restore backups and upload large files. |
| **A database** | An empty MariaDB or MySQL database, and a user with all privileges on it. Most panels put the account's name in front of both, such as `summit_itflow` - give the setup wizard the full names. |
| **ITFlow's files** | Downloaded with git into the site's folder, as the panel account that owns the site. ITFlow updates itself with git, so a zip, or a copy without the `.git` folder, can't be updated from **Admin > Update**. |
| **Cron** | `cron/cron.php` run every minute, as that same account, with the PHP version the site uses. |
| **HTTPS** | The panel's free Let's Encrypt certificate, with visitors sent from `http://` to `https://`. |

### ITFlow's private folders {#private-folders}

ITFlow keeps `config.php`, the `.git` folder, the `cron` and `scripts` folders, and the backups, receipts, exports and canned response files in `uploads` out of reach of the web, and stops anything in `uploads` from running as code, with `.htaccess` files. Apache reads them. nginx doesn't - and many panels put nginx in front of Apache and let it hand some files straight from the disk, or run nginx alone. Then the same rules have to go into nginx as well. Each panel's section says whether it needs them and how.

Those files have long random names that nobody can guess, but they shouldn't be reachable at all. Once ITFlow is set up, [check it's locked down](#check).

## HestiaCP {#hestiacp}

These steps are for HestiaCP as it installs by default: nginx in front of Apache, with PHP-FPM. Sign in to Hestia as a user of your own rather than `admin` - `summit` here - and run the commands as root over SSH.

### 1. Add the site {#hestia-site}

1. On **Web**, click **Add Web Domain**, enter `itflow.example.com` and click **Save**.
2. **Edit** the domain:
   - Tick **Enable SSL for this domain**, **Use Let's Encrypt to obtain SSL certificate** and **Enable automatic HTTPS redirection**.
   - Under **Advanced Options**, set **Backend Template** to PHP 8.2 or later, such as `PHP-8_4`.
3. Click **Save**.

### 2. Make the database {#hestia-database}

On **DB**, click **Add Database**. Enter `itflow` as the **Database** and as the **Username**, and **Generate** a password. Hestia puts your user's name in front of both, so they become `summit_itflow`. Leave **Charset**, under **Advanced Options**, at `utf8mb4`. Keep the password for the setup wizard.

### 3. Download ITFlow {#hestia-download}

Hestia puts a placeholder page in the site's folder, and git needs the folder empty:

```
cd /home/summit/web/itflow.example.com/public_html
rm index.html robots.txt
sudo -u summit git clone https://github.com/itflow-org/itflow.git .
```

Cloning as `summit` makes the files the site's own, so PHP can write `config.php` and save uploads.

### 4. Raise PHP's limits {#hestia-limits}

Make a file named `.user.ini` in the same folder - `sudo -u summit nano .user.ini` - with:

```ini
upload_max_filesize = 500M
post_max_size = 500M
max_execution_time = 300
```

PHP picks it up within 5 minutes. It applies to this site alone, and updating ITFlow leaves it as it is.

### 5. Keep the private folders private {#hestia-nginx}

Hestia's nginx hands images, documents and archives - receipts, backups and exports among them - straight from the disk without asking Apache, so ITFlow's `.htaccess` files never see those requests. Make a proxy template that refuses ITFlow's private folders:

```
cd /usr/local/hestia/data/templates/web/nginx
for t in tpl stpl; do
  sed 's|^\tlocation / {|\tlocation ^~ /uploads/backups/ { deny all; }\n\tlocation ^~ /uploads/canned_responses/ { deny all; }\n\tlocation ^~ /uploads/expenses/ { deny all; }\n\tlocation ^~ /uploads/tmp/ { deny all; }\n\n&|' default.$t > itflow.$t
done
```

That copies Hestia's `default` template as `itflow`, with these lines added before its `location / {`:

```nginx
location ^~ /uploads/backups/ { deny all; }
location ^~ /uploads/canned_responses/ { deny all; }
location ^~ /uploads/expenses/ { deny all; }
location ^~ /uploads/tmp/ { deny all; }
```

**Edit** the domain, set **Proxy Template**, under **Advanced Options**, to `itflow`, and click **Save**. Hestia's updates leave templates of your own alone.

> [!NOTE]
> If your Hestia runs nginx without Apache, nothing reads `.htaccess` files at all. Copy the template the domain uses, from `/usr/local/hestia/data/templates/web/nginx/php-fpm/`, the same way, add the lines under `# What ITFlow's .htaccess files keep private on Apache` in [Install by hand](/install/manual#nginx), and pick it as the domain's **Web Template**.

### 6. Add the cron job {#hestia-cron}

On **Cron**, click **Add Cron Job**. Set **Command** to the PHP of the site's version, then ITFlow's cron:

```
/usr/bin/php8.4 /home/summit/web/itflow.example.com/public_html/cron/cron.php >/dev/null
```

Put `*` in **Minute**, **Hour**, **Day**, **Month** and **Day of Week**, so it runs every minute, and click **Save**. Hestia runs it as `summit`, who owns ITFlow's files.

### 7. Run the setup wizard {#hestia-setup}

Open `https://itflow.example.com`. In the setup wizard's [Database](/install/setup#database) step, enter `summit_itflow` as the **Database name** and the **User**, `localhost` as the **Host**, and the password from step 2.

## cPanel {#cpanel}

cPanel runs PHP behind Apache, so ITFlow's `.htaccess` files work as they are - with cPanel's **NGINX with Reverse Proxy** too, which passes every request on to Apache. Hosts often limit what an account can change; where a step isn't open to you, ask your host.

1. **Download ITFlow.** In **Git™ Version Control**, click **Create**. Leave **Clone a Repository** on, and enter `https://github.com/itflow-org/itflow.git` as the **Clone URL**, `itflow.example.com` as the **Repository Path** - a folder that isn't there yet - and `ITFlow` as the **Repository Name**. Click **Create**.
2. **Add the site.** In **Domains**, click **Create A New Domain**. Enter `itflow.example.com`, untick **Share document root**, set the **Document Root** to `itflow.example.com` - the folder from step 1 - and click **Submit**.
3. **Pick PHP.** In **MultiPHP Manager**, tick the domain, pick PHP 8.2 or later and click **Apply**. If the setup wizard later says an extension is missing, turn it on in **Select PHP Version** where your host offers it, or ask your host.
4. **Raise PHP's limits.** In **MultiPHP INI Editor**, on **Basic Mode**, pick the domain. Set `upload_max_filesize` and `post_max_size` to `500M` and `max_execution_time` to `300`, and click **Apply**.
5. **Make the database.** With the **Database Wizard**, make a database named `itflow` and a user named `itflow`, and give the user **ALL PRIVILEGES**. cPanel puts your account's name in front of both, so they become `summit_itflow`.
6. **Get a certificate.** AutoSSL gives the domain one by itself - **SSL/TLS Status** shows it, and **Run AutoSSL** asks for it now. Then, in **Domains**, turn on **Force HTTPS Redirect** for the domain.
7. **Add the cron job.** In **Cron Jobs**, under **Add New Cron Job**, pick **Once Per Minute** in **Common Settings**. Set **Command** to the PHP of the site's version, then ITFlow's cron, and click **Add New Cron Job**:
   ```
   /opt/cpanel/ea-php84/root/usr/bin/php /home/summit/itflow.example.com/cron/cron.php >/dev/null
   ```
   `ea-php84` is PHP 8.4 - `ea-php83` for 8.3, and so on.
8. **Run the setup wizard.** Open `https://itflow.example.com`. The database and the user are both `summit_itflow`, on `localhost`.

> [!NOTE]
> Some hosts don't let a cron job run more often than every 5 or 15 minutes. ITFlow still works, but mail goes out and comes in that much later, and so does everything else cron does.

## Plesk {#plesk}

Plesk puts nginx in front of Apache and runs PHP through PHP-FPM. With its **Smart static files processing**, which is on by default, Apache decides about every request, so ITFlow's `.htaccess` files work. Leave **Serve static files directly by nginx**, in the site's **Apache & nginx Settings**, turned off: files it serves never reach Apache.

1. **Add the site.** Add `itflow.example.com` as a domain or a subdomain. A domain's folder is `httpdocs`, such as `/var/www/vhosts/itflow.example.com/httpdocs`.
2. **Pick PHP and raise its limits.** In the site's **PHP Settings**, pick PHP 8.2 or later, run as **FPM application served by Apache**. On the same page, set `upload_max_filesize` and `post_max_size` to `500M` and `max_execution_time` to `300`, and click **OK**.
3. **Make the database.** In **Databases**, click **Add Database**. Name it `itflow`, pick `itflow.example.com` as its **Related site**, and add a user named `itflow` with a strong password.
4. **Get a certificate.** In **SSL/TLS Certificates**, install the free certificate from Let's Encrypt, and turn on **Redirect from http to https**.
5. **Download ITFlow.** Plesk's Git extension puts a copy of the files in the site, without the `.git` folder ITFlow updates itself with - so clone it over SSH instead. Empty `httpdocs` in **File Manager** first, as Plesk puts a placeholder page there. Then, as root, clone it as the site's system user - `summit` here:
   ```
   sudo -u summit git clone https://github.com/itflow-org/itflow.git /var/www/vhosts/itflow.example.com/httpdocs
   ```
6. **Add the cron job.** In **Scheduled Tasks**, click **Add Task**. Pick **Run a PHP script**, enter `httpdocs/cron/cron.php` as the script, pick the site's version in **Use PHP version**, set **Run** to **Cron style** with `* * * * *`, and click **OK**.
7. **Run the setup wizard.** Open `https://itflow.example.com`, and give it the database and user from step 3, on `localhost`.

## Jabali {#jabali}

Jabali installs ITFlow for you, from **Applications**. It clones ITFlow with git, makes the database, runs setup, makes your account and adds the cron job.

1. Add `itflow.example.com` as a domain, with PHP 8.2 or later and SSL on. ITFlow goes at the root of a domain or subdomain.
2. In **Applications**, install **ITFlow** on that domain, with your company's name, and your name, email address and a password.
3. Open `https://itflow.example.com` and sign in with the email address.
4. Jabali sets ITFlow up for the United States, in US dollars, on UTC. If that's not you, change them in [Localization](/admin/settings#localization) under **Admin > Settings**.

Jabali's PHP settings start at 512 MB for uploads and 5 minutes for a page, so its limits need no change - unless your hosting package sets them lower.

Jabali serves sites with nginx alone, so ITFlow's `.htaccess` files do nothing there, and its ITFlow install adds no nginx rules of its own. An administrator can add them to the domain on the server, as root:

```
jabali domain set itflow.example.com --nginx-directives '
location ~ /\.(?!well-known/) { deny all; }
location = /config.php { deny all; }
location ^~ /cron/ { deny all; }
location ^~ /scripts/ { deny all; }
location ^~ /uploads/backups/ { deny all; }
location ^~ /uploads/canned_responses/ { deny all; }
location ^~ /uploads/expenses/ { deny all; }
location ^~ /uploads/tmp/ { deny all; }
location ^~ /uploads/ {
    location ~ \.(php|phtml|phar|phps|cgi|pl|sh)$ { deny all; }
}
'
```

## Check it's locked down {#check}

Once ITFlow is set up, open these two addresses. Both should be turned away, with an error page such as 401, 403 or 404:

- `https://itflow.example.com/.git/HEAD`
- `https://itflow.example.com/uploads/backups/index.php`

A line starting with `ref:`, or a blank page, means the web server isn't keeping ITFlow's [private folders](#private-folders) private. On Apache, the site doesn't allow `.htaccess` files. On nginx, the rules aren't in its config.

## Updates {#updates}

**Admin > Update** works the same on a panel: cron updates the files with git, as the site's account, then the database. It needs git on the server, and PHP's `exec` and `shell_exec` - some hosts turn those off. If ITFlow can't update itself there, see [Updating ITFlow](/install/updating).

Once the setup wizard is done, sign in: Get started takes you through the rest. See [After installing](/install/after-install).
