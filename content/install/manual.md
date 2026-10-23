---
title: Install by hand
description: Install ITFlow step by step on Debian or Ubuntu, with Apache or nginx, or fit it onto a server you already run.
---

These steps install ITFlow on Debian 13, Debian 12 or Ubuntu 24.04, using the same layout as [the install script](/install/install-script). Run the commands as root. Use your own domain wherever `itflow.example.com` appears.

## 1. Install the packages {#packages}

For Apache:

```
apt update
apt install apache2 libapache2-mod-php mariadb-server php php-mysql php-intl php-curl php-mbstring php-gd php-xml php-zip git cron sudo
```

For nginx, install `nginx php-fpm` instead of `apache2 libapache2-mod-php`.

## 2. Raise PHP's limits {#php-limits}

Restoring a backup or uploading a large file needs bigger limits than PHP comes with. Open PHP's settings, `/etc/php/8.4/apache2/php.ini`, or `fpm/php.ini` for nginx, and set:

```
upload_max_filesize = 500M
post_max_size = 500M
max_execution_time = 300
```

The folder is named after the PHP version: 8.4 on Debian 13, 8.3 on Ubuntu 24.04, and 8.2 on Debian 12. `php -v` shows yours.

## 3. Make the database {#database}

Open MariaDB with `mariadb`, then make a database and a user for ITFlow:

```sql
CREATE DATABASE itflow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'itflow'@'localhost' IDENTIFIED BY 'a-long-random-password';
GRANT ALL PRIVILEGES ON itflow.* TO 'itflow'@'localhost';
FLUSH PRIVILEGES;
```

`openssl rand -base64 24` makes a good password. You type it once, in the setup wizard, which saves it in `config.php`.

## 4. Download ITFlow {#download}

```
git clone https://github.com/itflow-org/itflow.git /var/www/itflow.example.com
chown -R www-data:www-data /var/www/itflow.example.com
```

Use `git clone` rather than a zip, so [Admin > Update](/install/updating) can update it. The web server's user has to own the folder: setup writes `config.php` into it, and everything you upload goes into its `uploads` folder.

## 5. Set up the web server {#web-server}

### Apache {#apache}

Make the site, in `/etc/apache2/sites-available/itflow.example.com.conf`:

```apache
<VirtualHost *:80>
    ServerName itflow.example.com
    DocumentRoot /var/www/itflow.example.com

    <Directory /var/www/itflow.example.com>
        AllowOverride All
        Options -Indexes
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/itflow.example.com-error.log
    CustomLog ${APACHE_LOG_DIR}/itflow.example.com-access.log combined
</VirtualHost>
```

Then turn it on, and turn off Apache's default site:

```
a2ensite itflow.example.com
a2dissite 000-default
systemctl reload apache2
```

> [!WARNING]
> Keep `AllowOverride All`. ITFlow comes with `.htaccess` files that keep `config.php`, the `.git` folder, the cron and scripts folders, backups and receipts out of reach of the web. They also stop anything uploaded from running as code. Debian and Ubuntu set Apache to ignore `.htaccess` files under `/var/www` unless the site allows them.

Run PHP through mod_php, as above. With PHP-FPM behind Apache, the `.htaccess` file in `uploads` stops uploaded images and files from loading.

### nginx {#nginx}

nginx doesn't read `.htaccess` files, so the site itself keeps those folders private. Make it in `/etc/nginx/sites-available/itflow.example.com`:

```nginx
server {
    listen 80;
    server_name itflow.example.com;
    root /var/www/itflow.example.com;
    index index.php;
    client_max_body_size 500M;

    # What ITFlow's .htaccess files keep private on Apache
    location ~ /\.(?!well-known/) { deny all; }
    location = /config.php { deny all; }
    location ^~ /cron/ { deny all; }
    location ^~ /scripts/ { deny all; }
    location ^~ /uploads/backups/ { deny all; }
    location ^~ /uploads/expenses/ { deny all; }
    location ^~ /uploads/tmp/ { deny all; }
    location ^~ /uploads/ {
        location ~ \.(php|phtml|phar|phps|cgi|pl|sh)$ { deny all; }
    }

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_read_timeout 300;
    }
}
```

Use the socket for your PHP version - `ls /run/php` shows it. Then turn the site on:

```
ln -s /etc/nginx/sites-available/itflow.example.com /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx
```

## 6. Get a certificate {#certificate}

```
apt install certbot python3-certbot-apache
certbot --apache -d itflow.example.com
```

For nginx, install `python3-certbot-nginx` and run `certbot --nginx -d itflow.example.com`. Certbot adds HTTPS to the site and renews the certificate by itself.

## 7. Add the cron entry {#cron}

Make `/etc/cron.d/itflow` with this one line:

```
* * * * * www-data php /var/www/itflow.example.com/cron/cron.php
```

It runs ITFlow's background work every minute, as `www-data`, the user that owns the files. Nothing runs until you [turn cron on](/install/after-install#cron) after setup.

## 8. Run the setup wizard {#setup}

Open `https://itflow.example.com`. ITFlow opens [the setup wizard](/install/setup), which connects to the database, makes your account and sets up your company.

### Or set up from the command line {#setup-cli}

`scripts/setup_cli.php` does the setup wizard's steps in one go, which is useful for scripted builds. Run it as `www-data`, so `config.php` belongs to the web server:

```
cd /var/www/itflow.example.com
sudo -u www-data php scripts/setup_cli.php
```

It asks for what it needs and suggests answers. To ask nothing, give everything as options:

```
sudo -u www-data php scripts/setup_cli.php --non-interactive \
  --database=itflow --username=itflow --password='a-long-random-password' \
  --base-url=itflow.example.com \
  --user-name="Alex Morgan" --user-email=alex@summitit.example --user-password='another long password' \
  --company-name="Summit IT Partners" --country="United States" --timezone=America/New_York
```

It works out the language and currency from the country, and the timezone too when the country has only one. Give `--timezone` for a country with several, and `--locale` or `--currency` to choose your own. `--help` lists every option, including the company's address and phone. When it's done, it shows the [backup key](/install/after-install#backup-key) and the cron line.

## Other ways to host it {#other-ways}

A control panel such as HestiaCP, or a container, can run ITFlow if it does what the steps above do:

- PHP 8.2 or later, with the extensions and limits in [Before you install](/install/requirements)
- An empty MariaDB or MySQL database, and a user that can create tables in it
- ITFlow's folder downloaded with git, and writable by the user PHP runs as
- On Apache, `.htaccess` files allowed. On nginx, rules that keep the same folders private.
- `cron/cron.php` run every minute, as that same user
- HTTPS

ITFlow's forum can help less with these setups, so be ready to sort out problems with them yourself.
