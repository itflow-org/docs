---
title: Maintenance
description: Keeping ITFlow running - cron and its jobs, backups and the encryption key, updates, the starter content library, and Debug's checks.
where: Admin > Maintenance
access: Admins
---

## Cron

Much of ITFlow happens in the background: sending email, reading the support mailbox, SLA alerts, recurring invoices and tickets, payment reminders, looking up domains and certificates, and backups. A single cron entry on your server runs it all, every minute:

```
* * * * * php /var/www/itflow/cron/cron.php >/dev/null
```

**Admin > Cron** shows whether cron is running - "Cron last checked less than a minute ago" - with the exact line for your server, and every job: its schedule, when it last ran, how long it took, how it went and when it runs next.

![Cron and its jobs](adm-cron.webp "Cron: whether it's running, and every job's schedule and last run")

| Job | Runs | Does |
|---|---|---|
| Mail Queue | every minute | Sends invoices, quotes, ticket replies and notifications |
| Text Messages | every minute | Sends the texts waiting to go, texts reminders of visits and calls coming up, and tidies the text log. Does nothing until [text messaging](/admin/text-messaging) is set up. |
| Ticket Email Parser | every minute | Turns email to your support mailbox into tickets and replies |
| Ticket SLA Monitor | every minute | Warns about SLAs close to a breach, and records breaches |
| AI Triage | every minute | Triages new tickets, when that's switched on |
| Payment Provider Fees | every 15 minutes | Records Stripe's fee on each card payment as an expense, when that's switched on |
| Manager Check-in | every minute | Checks in with the ITFlow that [manages this one](/admin/managed-instances#managed-by). Only there when managed mode is [turned on](/admin/managed-instances#turn-on). |
| Managed Instances | every 5 minutes | Notices [instances you manage](/admin/managed-instances) that have stopped checking in. Only there when managed mode is [turned on](/admin/managed-instances#turn-on). |
| Backup | daily | Makes the scheduled backup |
| Update Check | daily | Checks for a new version |
| Nightly Tasks | daily | Recurring invoices and tickets, reminders, autopay, late fees, clean-up |
| Certificate Refresher | daily | Checks every certificate |
| Domain Refresher | daily | Looks up domains that are due |
| Demo Reset | daily | Puts a [public demo](/install/demo) back to fresh demo data. Only there in demo mode, where the domain and certificate refreshers aren't. |

Each job's menu has **Run Now**, **Edit Schedule** (the time of day for a daily job) and **Disable**. **Turn cron off** stops every job at once without touching their schedules - what you want on a restored backup or a test copy, so it doesn't email clients or charge cards.

> [!WARNING]
> If cron stops, email stops going out, recurring invoices aren't made and SLAs aren't watched. ITFlow warns on the Cron, Mail Queue and Backup pages when it hasn't run for a few minutes.

## Backup

**Admin > Backup** says whether ITFlow is backed up, makes a backup when you want one, keeps the nightly schedule, and holds the encryption key backups need.

![Backup](adm-backup.webp "Backup: when the last one was made, the backups kept, the schedule, and the encryption key")

The top of the page says when the last backup was made, what kind it was, and when the next scheduled one is due. When something needs you, it says that instead: a backup is being made, the last one didn't finish and why, there hasn't been one for a week, none has been made yet, or one is waiting because cron isn't running.

- **Back up now** makes a Full Backup - the database and everything uploaded. This is the one to keep.
- **Database only** is just the database. Much smaller and quicker, but no files or documents.

Cron makes it within a minute, so cron needs to be running. The page keeps itself up to date while it does, the backup appears in the list when it's done, and you get a notification.

**Backups** lists those kept, newest first: who made each one or that the schedule did, its size, and when it was last downloaded. A failed one says why. **Download** saves one. Each backup's menu copies its path on the server, which restoring from the command line asks for, and its SHA-256 checksum, to check a copy kept somewhere else. The same menu deletes a backup, or takes one still waiting to be made off the queue.

**Schedule and retention** says whether a backup is made every night, and at what time. **Change the time** is beside it, and **Turn on** when the schedule is off - the same as the Backup job's menu in [Cron](#cron). Below that are the type made each night, how many days to keep backups, and the most to keep of each type. Old backups are removed by the nightly job, never by a backup itself, so one that fails never costs you the one before it.

**At a glance** has the last Full Backup and Database Only, how many backups are on the server and the room they take, the space left there, whether cron is running, and the folder they're kept in - inside ITFlow's own folder unless `$config_backup_path` in [config.php](/install/config-php) puts them somewhere else.

Every backup is an encrypted zip, and the **Encryption key** opens it. It's hidden until you click the eye, and the button beside it copies it. Keep a copy somewhere other than the server - without it, a backup can't be restored, by anyone.

**Export the master key**, under **Credential vault key**, gives you the key to the credential vault, for when every user's password is lost - a restore brings the vault back by itself as long as one user still knows theirs. It asks for your password, shows the key once, and files an encrypted copy with the backups. Every agent is notified that it was exported.

To restore, use `scripts/restore_cli.php` on the server - **Restoring** has the command to copy. On a brand new install, the setup wizard also has a restore step. [Moving to a new server](/install/moving) goes through both.

## Update

**Admin > Update** says where your install stands - up to date, an update available, an update running, or the database still to update - with the one button for it. Alongside are this install's version, the branch it updates from, its database version and commit, when it last checked for updates and last updated, and whether cron is running.

![Update](adm-update.webp "Update: a newer version waiting, what to do first, and what's new in it")

The Update Check job looks for updates once a day; **Check now** looks straight away. When a newer version is waiting, the page shows:

- **What's new** - each release's notes from the changelog, newest first, with any step of its own under **Upgrading**. The notes for developers and the commits behind them are folded away.
- **What to do first** - take a backup, read what's changing, pick a quiet time - and whether any of ITFlow's own files have been changed on this install. Updating puts back the released versions, so those changes would be lost. Your `config.php`, `uploads` and `custom` folders are never touched.

**Update ITFlow** hands the update to cron, which updates the files and then the database within a minute. The page shows it running and refreshes itself, then says when ITFlow was updated - or, if it stopped, what stopped it. When the database is behind ITFlow's files - after the files were put in place by hand, say - the button is **Finish updating**.

**From the command line** has the command to run the same update in a shell, with this server's folder and user filled in. See [Updating ITFlow](/install/updating).

An ITFlow [managed by another](/admin/managed-instances#managed-by) is updated from there, so it has no **Update ITFlow** button - the page says who updates it, and whether automatically.

> [!WARNING]
> Take a backup before updating - a snapshot of the server is safest - and read the changelog first: some releases need steps of their own.

## Starter content

**Admin > Starter Content** is a library of defaults for a typical MSP: categories, tags, ticket and project templates, canned responses, vendor templates, document templates, products and services, and license templates. Add whichever packs are useful - on a new install, or one that's been running for years.

![Starter content](adm-starter.webp "Starter content: libraries of templates, categories and products, with what's already here")

Each pack shows how many are in the library, how many you already have, and how many **Add** would bring in. **Add all** at the top adds every pack at once.

Adding never overwrites or deletes anything: what you already have under the same name is skipped, so adding twice never makes duplicates. When a newer version of ITFlow brings improved templates, **Update the ones you have** brings yours up to date.

### Pick which {#pick-which}

To add only some of a pack, open **Pick which** under it. It lists what the pack would add - only what you don't have yet - each as it will look: a category or tag with its colour and icon, a product with its price and how it's billed, a template with what it's for.

![Pick which, open on Products & Services](adm-starter-pick.webp "Pick which: what a pack would add, as it will look - untick what you don't want")

Everything is ticked to start with. Untick what you don't want, or use **All** and **None**. The count under **Will be added** follows - "75 of 77" - and **Add** adds only the ones ticked.

**Preview** shows a template in full before you add it - a ticket template's subject, category, tags, what it says and what it asks for; a document template's fill-ins and the document itself; a product's price and how it's billed.

![The preview of a document template](adm-starter-preview.webp "Preview: the Network Overview document template, as it comes in")

The [Starter content step](/install/after-install#starter-content) of Get started has the same packs, with Pick which and Preview.

Request forms come with the ticket templates, turned off - turn each on in its template's **Client portal** card. Products come priced as starting points: hardware and resold licensing at zero, because they're quoted per deal.

**Demo Data** removes the sample clients and records from a demo install, ready for your own.

## Debug

**Admin > Debug** checks the install and the server it runs on. It says first what needs putting right - problems, then warnings - each with what it found, what to do and a link to where to do it. When nothing does, it says everything looks good.

![Debug](adm-debug.webp "Debug: what needs a look first, the essentials along the top, then every check")

Along the top are the version and the database's version (with an update waiting), PHP, when cron last ran, failed email this week, the last backup and errors logged in the last day - each a link to its page. Below them, every check by section:

- **ITFlow** - the version, the database's version against the one the code expects, and whether updates can run here
- **Background jobs** - cron running and switched on (with the crontab line when it isn't), jobs that failed in the last day, and jobs switched off
- **Mail** - sending, email given up on or waiting to be tried again, and when the ticket mailbox was last read
- **Backups** - the last one, one that failed, and the backup folder
- **PHP** - the version, the extensions ITFlow needs, and the upload size, memory and time limits
- **Web and security** - HTTPS and the certificate, the address in ITFlow's emails against the one in use, and HTTPS only
- **Files and disk**, **Server** and **Errors logged** - the uploads folder, free space, the web and database servers, the time zone, and the latest errors

Further down are the database - its tables and size, the biggest tables, and any difference from a fresh install's tables and columns - and the uploads folder by size. **Count exactly** counts every table's rows, where the page shows the database's own estimate.

**Copy for support** puts the whole report on your clipboard as plain text, for a forum post or a support email: versions, what needs a look and the size of things, without host names, paths, addresses or keys. The same report is on the page, to read before you post it.

The page still opens when the database is behind the code - which is when you most need it.

## Other maintenance pages

- **Admin > Mail Queue** - every email sent or waiting. See [Mail](/admin/mail#the-mail-queue).
- **Admin > Text Messages** - every text sent and received, once texting is set up. See [Text messaging](/admin/text-messaging#log).
- **Admin > Audit Logs** and **App Logs** - see [Logs](/admin/logs).
