---
title: When something goes wrong
description: Where ITFlow and the server record what went wrong, the problems people meet most often after installing, and how to ask for help.
access: Server admins
---

## Where to look {#error-logs}

- **Admin > App Logs** - what ITFlow itself runs into: cron, mail, payment providers and the API. Start here when email isn't going out or a payment is refused. See [App logs](/admin/logs#app-logs).
- **The web server's error log** - PHP's errors, such as a blank page or "500". With the install script it's `/var/log/apache2/error.log`. [Installed by hand](/install/manual#apache), it's the site's own, `/var/log/apache2/itflow.example.com-error.log`. With nginx, it's `/var/log/nginx/error.log`. `tail -f` the log while you reload the page to see the error as it happens.
- **Admin > Debug** - the versions of ITFlow, PHP and the database, PHP's extensions and settings, and whether the database matches what the code expects.

## Common problems

### "Login is restricted as ITFlow defaults to HTTPS-only"

You opened ITFlow over plain http://. Get a certificate and use https://, as in [Install by hand](/install/manual#certificate). Behind a reverse proxy, the proxy has to tell ITFlow the visitor came over HTTPS - see [config.php](/install/config-php#proxy).

### A blank page, or "500 Internal Server Error"

PHP stopped on an error, and the web server's error log says which. It's often a PHP extension missing after PHP was upgraded. Install the extension for the new version, such as `apt install php8.4-intl`, and restart the web server.

### "Database Connection Failed"

ITFlow can't reach its database. Check MariaDB is running, with `systemctl status mariadb`, and that the database details in [config.php](/install/config-php) are right.

### "Potential Security Violation"

`config.php` tells ITFlow to read visitors' addresses from a proxy's header, but the request didn't come through the proxy. See [Behind a reverse proxy or Cloudflare](/install/config-php#proxy).

### "Your IP address has been blocked due to repeated failed login attempts"

After 15 failed sign-ins in 10 minutes, ITFlow turns away sign-ins from that address. The block lifts by itself once the failures are more than 10 minutes old. [Security and sign-in](/admin/security#failed-sign-ins) has more.

### Email isn't going out, or email isn't becoming tickets

Go to **Admin > Cron**:

- **Cron is not running** - the cron entry is missing or failing. The page shows the line to add. To see what goes wrong, run it yourself as the files' owner: `sudo -u www-data php /var/www/itflow.example.com/cron/cron.php`
- **Cron is switched off** - click **Turn cron on**.

If cron is running, look at [App Logs](/admin/logs#app-logs) and the [mail queue](/admin/mail#the-mail-queue) for what the mail server said.

### An upload fails, or a backup is too large to restore

PHP's limits are too low. Set `upload_max_filesize` and `post_max_size` to `500M`, and restart the web server - see [Install by hand](/install/manual#php-limits). With nginx, `client_max_body_size` must be as large. A backup bigger than that can be [restored from the command line](/install/moving#command-line), which has no limit.

### Setup says ITFlow's folder can't be written to

The web server's user has to own ITFlow's folder: `chown -R www-data:www-data /var/www/itflow.example.com`.

## Asking for help {#help}

Ask on the [ITFlow forum](https://forum.itflow.org). Say what you did, what happened, and what you expected, and include:

- The ITFlow version and database version, from **Admin > Update**
- The error from the web server's error log, or the App Logs entry
- How you installed ITFlow, and your OS, web server and PHP version, from **Admin > Debug**

Never post `config.php`, passwords, keys or your clients' data.
