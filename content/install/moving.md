---
title: Moving to a new server
description: Move ITFlow to a new server, or bring it back after losing one, with a full backup and its encryption key.
access: Admins
---

To move ITFlow, install a fresh copy on the new server and restore a full backup of the old one into it. The same steps bring ITFlow back after losing a server, as long as you have a backup and its key.

## 1. Take a full backup of the old server {#backup}

1. In [Admin > Backup](/admin/maintenance#backup), click **Full Backup**. Cron makes it within a minute, so cron needs to be running.
2. Download it from the list of backups.
3. Copy the **Encryption Key** shown on the same page. You'll need it to restore.

Data entered on the old server after this backup won't come across. Move out of hours, and ask your team to stop using the old server once the backup is made.

## 2. Install ITFlow on the new server {#install}

Install the same version or a newer one, [with the script](/install/install-script) or [by hand](/install/manual). Stop at the setup wizard, and don't make an account.

Then pause the new server's cron until you've switched over, so the two servers don't both email clients and charge cards:

```
mv /etc/cron.d/itflow /root/itflow.cron
```

## 3. Restore the backup {#restore}

A backup up to the upload limit (500 MB) can be restored in the browser, at the setup wizard's [Restore a backup](/install/setup#restore) step. Larger backups have to be restored from the command line.

### From the command line {#command-line}

Copy the backup onto the new server, such as into `/tmp`, then run:

```
cd /var/www/itflow.example.com
sudo -u www-data php scripts/restore_cli.php --file=/tmp/itflow_backup.zip --key='the old encryption key'
```

It asks you to type `restore`, then replaces the database and the `uploads` folder. If the restore fails, it puts the old database back. `--inspect` shows what's in a backup without changing anything.

Running as `www-data` keeps the restored files owned by the web server's user. That user needs to be able to read the backup file.

## 4. Switch over {#switch}

1. On the old server, go to **Admin > Cron** and click **Turn cron off**.
2. Point your domain name at the new server, and get its certificate. If ITFlow's address is changing, change `$config_base_url` in [config.php](/install/config-php) too.
3. If the backup came from an older version of ITFlow, bring its database up to date:
   ```
   sudo -u www-data php scripts/update_cli.php --update_db
   ```
4. Put the cron entry back: `mv /root/itflow.cron /etc/cron.d/itflow`
5. Open ITFlow. After a restore from the command line, the setup wizard opens, because setup was never finished on the new server. Click **Continue setup**, then **Finish and sign in**.
6. Sign in with an account from the backup. Its password and two-step sign-in are as they were on the old server.
7. In **Admin > Cron**, check cron is running and switched on.
8. Send a test email from [Admin > Settings > Mail](/admin/mail), and check a few clients' files open.

The new server has a backup key of its own. Copy it from [Admin > Backup](/admin/maintenance#backup): backups made from now on are locked with it. Backups from the old server still need the old key.

Keep the old server switched off, but don't delete it until you're sure nothing is missing.
