---
title: Updating ITFlow
description: Update ITFlow from Admin > Update or from the command line, and what to do first.
access: Admins
---

A new version of ITFlow comes with new features and fixes. Most updates change the files and then the database, and ITFlow does both for you.

## Before you update {#before}

- **Take a backup.** A snapshot of the whole VM is safest, because you can roll back in a minute if something goes wrong. Otherwise, make a [Full Backup](/admin/maintenance#backup) and copy it off the server.
- **Read the changelog.** It's on the Update page and on [GitHub](https://github.com/itflow-org/itflow/blob/master/CHANGELOG.md). Some releases need a step of their own, and each release says what changes for your team.
- **Pick a quiet time.** Your team may see errors for a minute or two while an update runs.

## From ITFlow {#from-itflow}

1. Go to **Admin > Update**. It shows the version you're on and whether a newer one is waiting.
2. Click **Queue Update**.

Cron picks the update up within a minute, updates the files and then the database, and records how it went on the Update page. Cron needs to be running. If it isn't, the update waits in the queue. See [Update](/admin/maintenance#update) for more on the page.

## From the command line {#command-line}

Run the updater as the user that owns ITFlow's files, `www-data` on Debian and Ubuntu:

```
cd /var/www/itflow.example.com
sudo -u www-data php scripts/update_cli.php
```

It updates the files to the newest version on your branch, then updates the database. Anything you changed in ITFlow's own files is overwritten. Your `config.php`, the `uploads` folder and the `custom` folders are left alone.

To update only the database - after restoring an older backup, say - run:

```
sudo -u www-data php scripts/update_cli.php --update_db
```

If you run it as another user, it stops and tells you which user to run it as.

## Releases and develop {#branches}

`$repo_branch` in [config.php](/install/config-php) decides where updates come from:

- `master` - the released versions. Use it for the ITFlow your team works in.
- `develop` - where new work lands first, before a release. Only use it on a test copy. Once develop has updated a database, there's no going back to master's version.
