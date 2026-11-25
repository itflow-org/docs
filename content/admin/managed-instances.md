---
title: Managing other ITFlow installs
description: Run other ITFlow installs from your own - see how each is doing, who its agents are and its history, have their problems open tickets, update them, set their seat limit and white label, sign in as support, and make one read-only or suspend it.
where: Admin > Managed Instances
access: Admins
---

One ITFlow can manage others: your clients' own ITFlows, a reseller's, or the ones you host. Each one checks in with yours every minute, so you see how they're all doing in one list - and their problems can open tickets - and from there you can update them, set how many agents they can have and their white-label key, sign in to one as support, and make one read-only or suspend it.

The ITFlow that manages is the **manager**; the ones it manages are **instances**. Any ITFlow can be either, or both - a reseller's ITFlow can be managed by its provider and manage its own clients'.

## Turn it on {#turn-on}

Managed mode is off on every ITFlow until a line in its `config.php` turns it on - see [config.php](/install/config-php#managed). Each side has its own line, added to the end of the file:

| On | Add | And it gets |
|---|---|---|
| The manager | `$config_enable_managed_instances = true;` | **Admin > Managed Instances** and the Managed Instances cron job |
| Each instance | `$config_enable_managed_by = true;` | **Admin > Managed By**, the Manager Check-in cron job and support sign-in |

A reseller's ITFlow that is managed and manages others has both lines. An ITFlow with neither shows nothing of managed mode - no menu entries, pages or cron jobs.

Taking a line out again keeps what's there. An instance stays connected but stops checking in, so its manager sees it go offline, and nothing the manager set is locked any more - read-only and suspended included. A manager keeps its instances: their check-ins are turned away until the line is back, and then they carry on.

## Add an instance

1. Go to **Admin > Managed Instances** and click **New Instance**.
2. Give it a **Name**, and pick the **Client** it belongs to, if it's a client's. **Address** is where it will be reached, such as `itflow.ravenwooddental.com` - it goes in the [setup command](#set-up-new). Once it connects, its address is the one it says it has.
3. On **Seats & updates** and **Access**, set what you want to control now - you can change it any time.
4. Click **Create**. Its page opens with a **connection code**.
5. Copy the code. It's shown this once, and works once, for a week.
6. On the other ITFlow - with managed mode [turned on](#turn-on) there too - an admin goes to **Admin > Managed By**, pastes the code and clicks **Connect**.

![A new instance and its connection code](adm-managed-instance-connect.webp "A new instance, waiting for its code")

The instance needs to be on the same version of ITFlow or newer, with cron running - it checks in from cron. It calls your ITFlow at its address, so that has to be reachable from where the instance is; nothing ever connects to the instance, so it can sit behind a firewall.

Your ITFlow can sit behind a web application firewall - ModSecurity with the OWASP Core Rule Set, say - with nothing to exclude for check-ins: an instance sends its report encoded, so the cron command and error text in it don't look like an attack. An instance on an older version sends it as plain text until it's updated, and a firewall may turn that away - its **Managed By** page says "The manager answered 403". Update it, or exclude the rule the firewall names for `/api/managed/checkin.php` until you do.

Lost the code, or moving the instance to a new server? **New Connection Code** in its menu makes another; the old one stops working, and whatever connects with the new one takes the place of what was connected.

### Set up a new install and connect it in one go {#set-up-new}

For an install you're setting up yourself - one you host for a client, say - the page also gives a command for [setting up from the command line](/install/manual#setup-cli) under **Setting up a new install for it?**, with the code in it. It fills in what your ITFlow knows: the address, and the client's company name, primary location, phone, website, tax ID and currency, with its primary contact as the first admin.

1. Download ITFlow into the new install's folder, and make an empty database for it - in the hosting control panel, if it has one.
2. Copy the command, and run it in that folder as the user that owns its files.
3. It asks for the database, and anything else it couldn't fill in, such as the time zone.
4. It sets ITFlow up and connects it with the code. Managed mode is turned on in its `config.php` and kept on (`--manager-required`), so its admins can't disconnect it. Take that option off the command if they should be able to.
5. It shows the password it made for the first admin - give it to them by a [secure link](/documentation/shared-links) - its backup key, and its cron job.
6. Add the cron job: in the crontab, or in the hosting control panel as a cron job that runs every minute with the command it shows.

Until its cron job runs, the instance shows as **Waiting for its cron job** here, with the command to add. Once it runs, the instance checks in every minute.

## See how they're doing

![Managed instances](adm-managed-instances.webp "Managed instances: each one's version, health, seats and last check-in")

The list shows each instance with its version and whether an update is waiting - a security update stands out - and whether it updates itself; what needs a look; its agents against its seat limit; its **Last 30 days** - tickets opened, how many of its agents signed in and when one last did, and API calls; and when it last checked in. Sort by **Last 30 days** to find the ones that are hardly used. A green dot is checking in, a red one has stopped, and a yellow one is a new instance **Waiting for its cron job** - connected, but its cron has never run.

Click an instance for everything it reported:

![An instance](adm-managed-instance.webp "An instance: what needs a look, what it's been asked, what you set and what it reported")

- **Health** lists what needs a look: cron switched off or not running, a database update not applied, the last update failed, an update or security update waiting, the last backup failed or none for three days, errors logged today and the categories they were logged under, every seat taken - or **All good**. A problem that has opened a [ticket](#problem-tickets) links to it.
- **Agents** lists who holds its seats: each active agent's name and email, their role, whether they sign in with MFA, and when they last signed in - then the invites waiting, with the day each runs out. API accounts are marked. Its support user isn't there, as it takes no seat. An instance on an older version shows only how many, until it's updated.
- **History** is how it has done day by day - its agents, clients, storage, uptime, errors and backups - and how much it's used. See [History](#history).
- **Requests** is what you've asked it to do - updates and checks for updates, yours and automatic ones - and how they went.
- **The instance** has its version, branch and database, when it last checked for updates, its agents and clients, last backup, cron, errors today, storage, PHP, time zone and where it checks in from. Under **Errors today**, the count and each category [sign you in to it as support](#sign-in-as-support) on its **App Logs**, showing just those errors.

You're notified when an instance stops checking in for ten minutes - or, for a new one, that it's still waiting for its cron job - and again when it's back, and when an update on one fails. Turn on [problem tickets](#problem-tickets) to have its problems open tickets as well.

### History {#history}

**History**, on an instance's page, shows how it has done a day at a time, over **30 days**, **90 days** or **1 year**:

![History](adm-managed-instance-history.webp "History: an instance's agents, clients, storage, uptime, errors and backups over 90 days")

- **Agents** against its seat limit, with the invites waiting, and its **Clients**.
- **Storage** - its uploads and its database.
- **Uptime** - the minutes each day it wasn't checking in, counting only gaps of more than ten minutes, with the latest gaps listed: when each started and how long it lasted.
- **Errors** each day, with the categories they came under over the period.
- **Backups** - a strip of the days: a backup made, one that failed, or none.

Under **Usage**, the same period shows how much it's used, as it counts it by its own date:

![Usage](adm-managed-instance-usage.webp "Usage: tickets, replies, sign-ins, billing, email and API calls over 90 days")

- **Tickets** opened and resolved each day, and how many came in by email.
- **Replies** - replies and notes by its agents.
- **Signing in** - how many of its agents signed in each day, how many signed in over the last 30 days, and the client portal sign-ins.
- **Billing** - invoices made and payments recorded.
- **Email** sent, and email that failed.
- **API calls**, with the keys that made the most of them, by name.

Over a year, the bar charts and backups go by the week. History is kept for good - a line a day for each instance - from the day your ITFlow started keeping it; there's none from before. An instance shows its usage once it's on a version that counts it.

> [!NOTE]
> Instances send how they're doing and who their agents are - never tickets, documents, credentials, invoices or contacts. Of their errors they send only how many and the categories they were logged under, never what they say, as an error can hold a client's email address or a ticket's subject. Of their use they send only counts - how many tickets, replies, invoices, payments, sign-ins, emails and API calls, with each API key's name. Their admins can see exactly what's sent on **Admin > Managed By**.

## Problem tickets {#problem-tickets}

An instance's problems can open tickets, so they land in your queue with the rest of your work. It's off to start with.

1. On **Admin > Managed Instances**, click **Problem Tickets**.
2. Pick which **Problems open tickets**:
   - **Problems** - it has stopped checking in, cron isn't running, an update failed, its database update isn't applied, or a security update is waiting on one that doesn't update itself. These open at High priority.
   - **Problems and warnings** - those, and its backups failing or none for three days, and errors being logged. Warnings open at Medium.
3. Pick a **Ticket category** for them, if you like, and click **Save**.

![Problem Tickets](adm-managed-problem-tickets.webp "Problem Tickets: which problems open tickets, and their category")

- A problem opens a ticket once it has lasted ten minutes, so a blip doesn't. The ticket is on the instance's client - or, when it has none, on your own client record, set in [Company details](/admin/settings#company-details); with neither, it waits until one is set. It says what's wrong, with the instance's address, version and last check-in, what to look at, and a link to its page here.
- The same problem coming back goes on its ticket as a note while that isn't closed, and reopens it if it was resolved.
- When the problem clears, the ticket gets a note and is resolved - unless someone has written on it, and then it stays as it is for you to close.
- A new instance waiting for its cron job opens none, and neither does a suspended one. A problem already there when you turn this on opens a ticket too, once it has lasted ten minutes.
- On an instance's page, each problem under **Health** links to its ticket.

## Update instances

When an update is waiting, **Update to** on its page (or **Update Now** in its menu in the list) updates it: it picks the request up at its next check-in, then updates its files and database in the background, the same as **Update ITFlow** on its own [Update page](/admin/maintenance#update). The page shows it updating and refreshes itself until it's done. **Check for Updates** in its menu has it check straight away.

Or let it update itself: on **Seats & updates**, set **Updates** to **Automatically** and how many days to **Wait** after a release comes out. A release with security fixes goes on at its next check-in, without waiting. If an automatic update fails, it isn't tried again for six hours.

![Seats and updates](adm-managed-instance-form.webp "Seats & updates: the seat limit, updates and white-label key")

Either way, the instance's own admins can't update it - its Update page says it's updated from you.

## Seats and white label

On **Seats & updates**:

- **Seat limit** - how many active agents it can have. Invites waiting count, so a seat is there when they join. Its admins can't add agents past it. Left empty, its own `config.php` decides, as on any ITFlow.
- **White-label key** - a key from the ITFlow project that takes "Powered by ITFlow" off it. While it's set here, its admins can't change it; take it out and white label is theirs to set again.

## Read-only and suspended

On **Access**, or from **⋮** on its page:

- **Read-only** - its people can sign in, look around, export and download, but nothing can be changed: agents, the client portal and guest links alike. Mail still goes out, and backups and updates still run. Every page says so.
- **Suspended** - nobody can use it. Agents, the client portal, guest links and the API get a notice instead, with your email and phone. Its data stays as it is, and backups and updates still run.

![A suspended instance](adm-managed-suspended.webp "What a suspended instance's people see")

Add a **Message** to say why - "Your subscription has ended - call us to carry on". **Make it active** puts it back. Each change takes effect at its next check-in, within a minute. While it's read-only or suspended, its other background jobs wait, and run once it's active again.

## Sign in as support

**Sign In as Support** opens the instance in a new tab, signed in as its support user - an admin, so you can see what its people see and put things right.

- No password is involved: the link is signed by your ITFlow, works once, and only for two minutes.
- The session lasts two hours. A banner across every page says it's a support session, from whom, and when it ends.
- It works when the instance is read-only or suspended too.
- The support user doesn't take one of its seats, and can only be signed in to from your ITFlow.
- It can't open saved passwords - that takes a user's own password - so a support session can't see or change them, set anyone's password or make API keys. Invite people instead, or ask one of its admins.
- Each sign-in is in its audit log with your name, and its agents are notified. Yours records it too.

## Remove an instance

**Remove**, in its menu, stops managing it. At its next check-in it lets go: what you set comes off it - the seat limit and white-label key - its support user is archived, and it's an ordinary ITFlow again. Its data stays where it is. Removed instances are under **Removed**, where they can be deleted.

## Being managed {#managed-by}

**Admin > Managed By** is the instance's side. Before it's connected, it's where the connection code goes. After, it shows who manages it and how to reach them, when it last checked in - or why it couldn't - and what the manager sets, with everything else still yours.

![Managed By](adm-managed-by.webp "Managed By: who manages this ITFlow, what they set, and what it tells them")

**Check In Now** checks in straight away rather than waiting for cron - after the manager makes it active again, say. **Disconnect** stops it being managed: the manager is told, its support sign-ins stop, and what it set comes off.

> [!NOTE]
> For an ITFlow you host for a customer, add `$config_manager_required = true;` to its `config.php`. It turns **Managed By** on, as `$config_enable_managed_by` does, and its admins then can't disconnect it.
