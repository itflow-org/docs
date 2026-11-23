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

**Admin > Cron** says whether cron is running, and how each job is doing.

![Cron and its jobs](adm-cron.webp "Cron: whether it's running, how each job's last run went, and the cron line for your server")

The top of the page says when cron last ran, how many jobs are on, and which runs next. When something needs you, it says that instead:

- **Cron hasn't run yet**, or **Cron has stopped** - the cron entry is missing or failing. The line for your server is there, with a button that copies it, and the page says so by itself once cron runs.
- **Cron is switched off** - every job stops itself until you click **Turn Cron On**.
- A job failed - the top of the page names it, and what went wrong is under the job.

**Jobs** lists each job with what it does, its schedule and when it next runs, when it last ran and how long that took, and how it went:

- **Completed** - it ran.
- **Skipped** - it had nothing to do, or what it works with isn't set up. It says why under its name - texting isn't set up, say.
- **Failed** - it stopped with an error, shown under the job - the email parser not reaching your mail server, say, with what the server answered. The error stays until you click **Dismiss**, and once the job has run again it says so. A run cut off part way - by a restart, say - reads **Didn't finish**.
- **Queued** or **Running** - it's on its way, and the page keeps itself up to date until it's done.

The list starts in the order the day runs - the every-minute jobs, then the nightly ones by time - and sorts by its headings.

| Job | Runs | Does |
|---|---|---|
| Mail Queue | every minute | Sends invoices, quotes, ticket replies and notifications |
| Text Messages | every minute | Sends the texts waiting to go, texts reminders of visits and calls coming up, and tidies the text log. Does nothing until [text messaging](/admin/text-messaging) is set up. |
| Ticket Email Parser | every minute | Turns email to your support mailbox into tickets and replies |
| Ticket SLA Monitor | every minute | Warns about SLAs close to a breach, and records breaches |
| Reminders | every minute | Sends the [reminders](/service-desk/calendar#reminders) of events and of work booked on tickets |
| AI Triage | every minute | Triages new tickets, when that's switched on |
| Payment Provider Fees | every 15 minutes | Records Stripe's fee on each card payment as an expense, when that's switched on |
| RMM Sync | every 15 minutes | Brings in the devices of the clients linked to your [RMM](/admin/rmm) and of the sites linked to your [network platforms](/admin/network-platforms), and keeps their assets up to date. Does nothing until one is set up. |
| RMM Alerts | every minute | Opens a ticket for each new alert from an RMM whose alerts open tickets, or for a device that goes offline on a [network platform](/admin/network-platforms#offline-alerts), and resolves it when the alert clears. See [RMM providers](/admin/rmm#alerts). |
| Manager Check-in | every minute | Checks in with the ITFlow that [manages this one](/admin/managed-instances#managed-by). Only there when managed mode is [turned on](/admin/managed-instances#turn-on). |
| Managed Instances | every 5 minutes | Notices [instances you manage](/admin/managed-instances) that have stopped checking in. Only there when managed mode is [turned on](/admin/managed-instances#turn-on). |
| Backup | daily | Makes the scheduled backup, and any started from [Backup](#backup). Off until the schedule is turned on. |
| Update Check | daily | Checks for a new version |
| Application Update | when asked | Runs an update started from [Update](#update). Off, as there's nothing for it to do until then. |
| Nightly Tasks | daily | Recurring invoices and tickets, reminders, autopay, late fees, clean-up |
| Certificate Refresher | daily | Checks every certificate |
| Domain Refresher | daily | Looks up domains that are due |
| Cron Watch | every 5 minutes | Emails your admins when a job fails, gets stuck or falls behind. See [Alerts](#cron-alerts). |
| Demo Reset | daily | Puts a [public demo](/install/demo) back to fresh demo data. Only there in demo mode, where the domain and certificate refreshers aren't. |

Each job's menu has:

- **Run Now** - cron picks the job up within a minute, even when it's turned off.
- **Change the Schedule** - every so many minutes, or once a day at a time you choose. Nightly Tasks, Backup and Application Update only run once a day.
- **Copy the Command to Run It** - the command that runs that one job on the server, where it shows what it does as it goes.
- **Turn Off** - it no longer runs on its schedule, and shows **Off**. **Turn On** puts it back.

Beside the list, **At a glance** has whether cron is running, when it last ran, how many jobs are on and off, any that failed, the next job due, and the time zone the schedules are in. **Alerts** says who hears when something goes wrong - see [below](#cron-alerts). **The cron job** has the line for your server. **Turn Cron Off** stops every job at once without touching their schedules - what you want on a restored backup or a test copy, so it doesn't email clients or charge cards.

> [!WARNING]
> If cron stops, email stops going out, recurring invoices aren't made and SLAs aren't watched. ITFlow warns on the Cron, Mail Queue and Backup pages when it hasn't run for a few minutes.

### Alerts {#cron-alerts}

The **Cron Watch** job emails your admins when a job needs looking at: once when a problem starts, again once a day while it lasts, and once more when it's fixed - or, when everything is, an all clear. It emails when:

- a job failed on its last run, with its error
- a job is still running two hours after it started, and may have stopped part way
- a job has fallen behind - an every-minute job that hasn't run for ten minutes, say, or a nightly one two hours after its time

Cron Watch runs on cron, so it can't email when cron itself has stopped or is switched off. The Cron, Mail Queue and Backup pages say so, and an [uptime monitor](#uptime-monitor) can tell you.

![The Alerts card](adm-cron-alerts.webp "Alerts: who the emails go to, and the address for an uptime monitor")

On the **Alerts** card beside the jobs:

- **Email alerts** - turn it off and nothing is emailed. The uptime monitor address still works.
- **Send to** - the addresses the emails go to, with commas between. Leave it empty and they go to every active admin, who are listed under it.
- **Send a Test** - sends a test to the addresses in the box, saved or not. It goes out with the mail queue within a minute, so cron and [mail](/admin/mail) need to be working.

The card says when no alert can be emailed - Cron Watch is off, or no mail server is set up.

#### Uptime monitor {#uptime-monitor}

An email can't tell you cron has stopped - it's cron that sends it. For that, point an uptime monitor such as Uptime Kuma or UptimeRobot at the address under **Uptime monitor**, every 5 minutes:

- while all is well it answers `OK`
- otherwise it answers with an error (HTTP 503) and a line for each problem

Your monitor tells you when that happens, however cron is doing.

The address has a key in it, so keep it private: anyone with it can see which jobs are failing. If it gets out, click the red button beside it to make a new one. The old one stops working, so give your monitor the new address. A monitor that can send headers can send the key in an `X-Health-Key` header to `/health.php` instead, which keeps it out of your web server's log.

## Backup

**Admin > Backup** says whether ITFlow is backed up, makes a backup when you want one, keeps the nightly schedule, and holds the encryption key backups need.

![Backup](adm-backup.webp "Backup: when the last one was made, the backups kept, the schedule, and the encryption key")

The top of the page says when the last backup was made, what kind it was, and when the next scheduled one is due. When something needs you, it says that instead: a backup is being made, the last one didn't finish and why, there hasn't been one for a week, none has been made yet, or one is waiting because cron isn't running.

- **Back Up Now** makes a Full Backup - the database and everything uploaded. This is the one to keep.
- **Database Only** is just the database. Much smaller and quicker, but no files or documents.

Cron makes it within a minute, so cron needs to be running. The page keeps itself up to date while it does, the backup appears in the list when it's done, and you get a notification.

**Backups** lists those kept, newest first: who made each one or that the schedule did, its size, and when it was last downloaded. A failed one says why. **Download** saves one. Each backup's menu copies its path on the server, which restoring from the command line asks for, and its SHA-256 checksum, to check a copy kept somewhere else. The same menu deletes a backup, or takes one still waiting to be made off the queue.

**Schedule and retention** says whether a backup is made every night, and at what time. **Change the Time** is beside it, and **Turn On** when the schedule is off - the same as the Backup job's menu in [Cron](#cron). Below that are the type made each night, how many days to keep backups, and the most to keep of each type. Old backups are removed by the nightly job, never by a backup itself, so one that fails never costs you the one before it.

**At a glance** has the last Full Backup and Database Only, how many backups are on the server and the room they take, the space left there, whether cron is running, and the folder they're kept in - inside ITFlow's own folder unless `$config_backup_path` in [config.php](/install/config-php) puts them somewhere else.

Every backup is an encrypted zip, and the **Encryption key** opens it. It's hidden until you click the eye, and the button beside it copies it. Keep a copy somewhere other than the server - without it, a backup can't be restored, by anyone.

**Export the Master Key**, under **Credential vault key**, gives you the key to the credential vault, for when every user's password is lost - a restore brings the vault back by itself as long as one user still knows theirs. It asks for your password, shows the key once, and files an encrypted copy with the backups. Every agent is notified that it was exported.

### Restoring {#restore}

A restore replaces the database - and, from a Full Backup, everything uploaded - with what's in the backup. Before it does, ITFlow backs itself up as it is, and keeps that in the list as **Before restore**, so a restore can be undone by restoring that one.

To restore a backup in the list, pick **Restore** in its menu. To restore one that isn't here - from another ITFlow, or one you downloaded - upload it under **Restoring**, with its encryption key if another ITFlow made it. It joins the list as **Uploaded**, and its Restore window opens. A backup up to 5 GB can be uploaded: it goes up in pieces, so keep the page open until it's done.

![Restoring](adm-backup-restoring.webp "Restoring: upload a backup to restore, or restore from the command line")

The Restore window says what's in the backup - when it was taken, its database version against this ITFlow's, and whether it holds the uploads. A backup from a newer version of ITFlow can't be restored until you update this one. One made on another ITFlow asks for that ITFlow's key. Type your password and **RESTORE** to confirm.

![The Restore window](adm-backup-restore.webp "The Restore window: what's in the backup, then your password and RESTORE")

Like a backup, the restore is done by cron, within a minute. The top of the page says it's waiting, with **Cancel the Restore**, then that it's running, and keeps itself up to date. A restore not started within an hour - cron was stopped - isn't done at all. While it runs, the other cron jobs wait, and anyone working may see errors. After it, the database is brought up to this version of ITFlow if the backup was older. If your account or password is different in the backup, you're asked to sign in again - with an account from the backup. The top of the page says how the last restore went for a week afterwards.

A restore needs free space of about three times the backup's size. **From the command line**, under **Restoring**, has the command for a backup of any size, or for when cron isn't running. On a brand new install, the setup wizard also has a restore step. [Moving to a new server](/install/moving) goes through both.

> [!TIP]
> Restoring production's backup onto a test server? Turn on [development mode](#dev-mode) on the test server first.

### Development mode {#dev-mode}

For a test copy of your ITFlow - a second server you restore production's backup onto, to try an update or a new way of working. A copy of production would otherwise carry on as production does: emailing your clients, charging their cards, reading your support mailbox. Turn development mode on **before** you restore onto it.

![Development mode](adm-dev-mode.webp "Development mode, on: every email goes to the test inbox")

Under **Development mode** on **Admin > Backup**, switch it on, give a **Test inbox** and click **Save**. While it's on:

- every email goes to the test inbox instead, with who it was for at the front of its subject - "[DEV to marla@ravenwood.example] Invoice INV-1042"
- texts aren't sent - they wait in the queue
- the support mailbox isn't read, so production still gets its email
- AI Triage doesn't run
- Stripe charges nothing - card payments, saving a card and autopay all stop
- RMM devices still come in, but no action is done to one
- log entries aren't sent to your syslog server
- a [managed](/admin/managed-instances) ITFlow doesn't check in with its manager
- the install details aren't shared with the ITFlow project

Everyone sees a red **DEVELOPMENT** badge in the top bar, and the jobs that stop say why on [Cron](#cron).

It's kept in [config.php](/install/config-php#dev-mode), not the database, so restoring a backup can't turn it off. When ITFlow can't write to config.php, the card shows the two lines to add on the server.

> [!WARNING]
> Never turn development mode on in production - nobody would get your email.

## Update

**Admin > Update** says where your install stands - up to date, an update available, an update running, or the database still to update - with the one button for it. Alongside are this install's version, the branch it updates from, its database version and commit, when it last checked for updates and last updated, and whether cron is running.

![Update](adm-update.webp "Update: a newer version waiting, what to do first, and what's new in it")

The Update Check job looks for updates once a day; **Check Now** looks straight away. When a newer version is waiting, the page shows:

- **What's new** - each release's notes from the changelog, newest first, with any step of its own under **Upgrading**. The notes for developers and the commits behind them are folded away.
- **What to do first** - take a backup, read what's changing, pick a quiet time - and whether any of ITFlow's own files have been changed on this install. Updating puts back the released versions, so those changes would be lost. Your `config.php`, `uploads` and `custom` folders are never touched.

**Update ITFlow** hands the update to cron, which updates the files and then the database within a minute. The page shows it running and refreshes itself, then says when ITFlow was updated - or, if it stopped, what stopped it. When the database is behind ITFlow's files - after the files were put in place by hand, say - the button is **Finish updating**.

**From the command line** has the command to run the same update in a shell, with this server's folder and user filled in. See [Updating ITFlow](/install/updating).

An ITFlow [managed by another](/admin/managed-instances#managed-by) is updated from there, so it has no **Update ITFlow** button - the page says who updates it, and whether automatically.

> [!WARNING]
> Take a backup before updating - a snapshot of the server is safest - and read the changelog first: some releases need steps of their own.

## Starter content

**Admin > Starter Content** is a library of defaults for a typical MSP: categories, tags, ticket and project templates, canned responses, Knowledge Base articles, vendor templates, document templates, products and services, and license templates. Add whichever packs are useful - on a new install, or one that's been running for years.

![Starter content](adm-starter.webp "Starter content: how much there is to add, each pack with its Add, and the totals at a glance")

The top of the page says how much of the library you don't have yet, and **Add all** adds all of it at once. Each pack under it says how many it would add and how many of it you already have, with its own **Add**. **At a glance**, at the side, has the totals.

Adding never overwrites or deletes anything: what you already have under the same name is skipped, so adding twice never makes duplicates. When a newer version of ITFlow brings improved templates, **Update**, beside a pack you have some of, brings yours up to date - it asks first, as it replaces what they hold.

### Pick which {#pick-which}

To add only some of a pack, open **Pick which** under it. It lists what the pack would add - only what you don't have yet - each as it will look: a category or tag with its colour and icon, a product with its price and how it's billed, a template with what it's for.

![Pick which, open on Products & Services](adm-starter-pick.webp "Pick which: what a pack would add, as it will look - untick what you don't want")

Everything is ticked to start with. Untick what you don't want, or use **All** and **None**. The count beside the pack's name follows - "74 of 76 to add" - and **Add** adds only the ones ticked.

**Preview** shows a template in full before you add it - a ticket template's subject, category, tags, what it says and what it asks for; a document template's fill-ins and the document itself; a product's price and how it's billed.

![The preview of a document template](adm-starter-preview.webp "Preview: the Network Overview document template, as it comes in")

### Clear out unused {#clear-out}

**Clear out unused**, beside a pack's counts, is there when some of what you have from it isn't used yet: a category no ticket, invoice, expense or product has, a tag on nothing, a template nothing was made from, a canned response never put in a reply, a Knowledge Base article still the draft it came in as, or a product on no invoice, quote or asset. It lists them, all ticked, and says how many are in use and stay. Untick what you want to keep and click **Archive Them**.

![Clear out unused, open on Categories](adm-starter-clear.webp "Clear out unused: what came from the Categories pack that nothing uses yet, to archive")

They're archived, not deleted: **Undo** on the message puts them back, and any can be restored later from its own list's archived view. **Add** still counts them as here, so it doesn't make them again.

The [Starter content step](/install/after-install#starter-content) of Get started has the same packs, with Pick which and Preview.

Request forms come with the ticket templates, turned off - turn each on in its template's **Client portal** card. Knowledge Base articles come in as drafts only your team can see - see [Start from the starter articles](/service-desk/knowledge-base#starter). Products come priced as starting points: hardware and resold licensing at zero, because they're quoted per deal.

**Demo data**, under the packs, adds the sample clients and records for a demo or training install, and **Remove Demo Data** takes them out again in one go when you're ready for your own - it asks first, as it can't be undone.

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

**Copy for Support** puts the whole report on your clipboard as plain text, for a forum post or a support email: versions, what needs a look and the size of things, without host names, paths, addresses or keys. The same report is on the page, to read before you post it.

The page still opens when the database is behind the code - which is when you most need it.

## Other maintenance pages

- **Admin > Mail Queue** - every email sent or waiting. See [Mail](/admin/mail#the-mail-queue).
- **Admin > Text Messaging > Messages** - every text sent and received, once texting is set up. See [Text messaging](/admin/text-messaging#log).
- **Admin > Logs** - **Audit Logs**, **Sign-ins** and **App Logs**, as tabs. See [Logs](/admin/logs).
