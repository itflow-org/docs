---
title: Mail
description: Connect ITFlow to your mail - sending invoices, replies and alerts, and reading your support mailbox to turn email into tickets - and check what goes out.
where: Admin > Settings > Mail
access: Admins
---

ITFlow sends a lot of email - ticket replies, invoices, quotes, reminders, alerts - and can read your support mailbox to turn incoming email into tickets. Both are set up in **Admin > Settings > Mail**, on its tabs: **Sending**, **Receiving**, **From Addresses**, **Tests** and **Previews**. A green dot on **Sending** and **Receiving** means each is set up.

## Sending

Under **Send through**, pick how email goes out:

- **An SMTP server - with a username and password** - your own mail server, or a service such as SMTP2GO, Mailgun or Amazon SES
- **Google Workspace - signed in with OAuth**
- **Microsoft 365 - signed in with OAuth**
- **Off** - ITFlow sends no email at all, and keeps nothing to send later

For a server, type the **Server**, **Port** and **Encryption** (STARTTLS, usually port 587, or SSL/TLS, usually 465), and the **Username** and **Password** it signs in with. Many hosts want an app password rather than the account's own.

![Mail settings, sending through an SMTP server](adm-mail.webp "Sending: how email goes out")

For Google or Microsoft, register an app with them and put its details under **The app** - **Client ID**, **Client secret** and, for Microsoft, **Tenant ID** - then connect the mailbox. The page gives you the **Redirect address** to paste into the app registration. Sending and receiving share the same app.

### Microsoft 365 through Microsoft Graph {#microsoft-graph}

Microsoft 365 can send email and read your support mailbox through Microsoft Graph instead of SMTP and IMAP. The mailbox then doesn't need SMTP AUTH, which Microsoft switches off by default.

1. In Microsoft Entra, open the app registration and go to **API permissions**.
2. Add the **Microsoft Graph** delegated permissions **Mail.Send**, to send, and **Mail.ReadWrite**, to read the mailbox. If ITFlow reads or sends as a shared mailbox, add **Mail.ReadWrite.Shared** and **Mail.Send.Shared** too.
3. Click **Grant admin consent**.
4. In ITFlow, on the **Tests** tab, click **Test OAuth Token Refresh**. It says how email now goes.

ITFlow uses Graph for whichever it has permission for, and SMTP or IMAP for the rest - there's nothing to switch on. On the **OAuth** tab, **Connecting the mailbox** says which way email goes. ITFlow checks again every hour, and straight away when you save the app or connect again.

![Connecting the mailbox, with email going through Microsoft Graph](adm-mail-graph.webp "Connecting the mailbox: email sent and the mailbox read through Microsoft Graph")

Through Graph, **Test IMAP** checks the mailbox through Graph instead. A copy of each email ITFlow sends goes to the mailbox's **Sent Items**, and an email that's too big to send in one go - with big attachments - is sent in parts.

Saved passwords and secrets are never shown again. Leave a field empty to keep what's saved.

## Receiving

Under **Read mail from**, pick an IMAP server, Google Workspace or Microsoft 365, and the mailbox to read - usually your support address. Then switch on **Turn emails into tickets** in [ticket settings](/admin/tickets#email-to-ticket).

Every minute, the Ticket Email Parser job reads the mailbox: a new email becomes a ticket, and a reply goes onto its ticket, found by the ticket number in its subject.

Emails about a ticket start with **##- Please type your reply above this line -##**. A reply keeps what was written above that line, so the email it quotes doesn't land on the ticket again. Some mail programs put a reply under the email it quotes, and some people type below the line - what they wrote below the quote is kept instead, or as well. When nothing was written above the line and their words can't be told from the quote - typed into the middle of it - the whole email goes on the ticket, with a note saying so, rather than nothing.

Who a reply is from decides what it does:

- **The client's contact** - a client reply, which reopens the ticket.
- **A watcher** - an internal note, and the ticket reopens.
- **One of your agents** - their own internal note. The ticket stays as it is.
- **Anyone else** - an internal note marked as from someone who isn't a contact, watcher or agent. The ticket stays as it is, and the email's attachments aren't added - they stay with the email in the mailbox's **ITFlow** folder. Anyone can put a ticket's number in a subject, so a stranger can't reopen your tickets or add files to them.

## From addresses

The address and name each kind of email comes from - **System emails** (alerts, password resets), **Invoices**, **Quotes** and **Tickets** - such as `billing@` for invoices and `support@` for tickets. Each has to be an address the sending mailbox may send as: itself, an alias, or a shared mailbox it can send as.

## Tests and previews

**Tests** sends a test email, checks that the support mailbox can be read, and - with Google or Microsoft - that the sign-in still works, so you see a problem before your clients do.

**Previews** shows every email ITFlow sends, as it goes out - with your logo, your details and your From addresses - and who gets it. Each is made on sample records, so looking sends and saves nothing. **Send me a copy** sends one to you, to see it in your own mail app.

![Previews of every email ITFlow sends](adm-mail-previews.webp "Previews: every email, who gets it, and how it looks")

## The mail queue

Everything ITFlow sends goes through **Admin > Mail Queue**. The Mail Queue job sends what's waiting every minute.

![The mail queue](adm-mail-queue.webp "The mail queue: what's been sent, what's waiting and what failed")

The tabs are **Waiting**, **Sending**, **Retrying**, **Failed**, **Sent** and **Cancelled**. A failed email is tried again a few times before it's marked **Failed** - its row says why, such as an address that doesn't exist. Tick emails to **Retry now**, **Cancel** or **Delete** them. Sent, failed and cancelled email is kept for 90 days.

Click an email to see it as it went. A sent email keeps what it said, its attachments and its calendar file. One with a link or code that opens something - a shared login and its code, a client portal or agent invite, a password link, a contract to sign or a task to approve - is cleared once it's sent, so the link isn't kept where others can see it, and a day after it was queued if it failed or was cancelled. One cleared like that can't be retried: send a new one from where it came from.

If something is stopping email going out - sending switched off, or cron not running - it says so at the top.

A ticket's conversation shows the same for each email reply: who it was emailed to and whether each one was sent, is waiting, or failed. See [The conversation](/service-desk/working-a-ticket#the-conversation).

## Notifications

**Admin > Settings > Notifications** decides which emails ITFlow sends clients by itself, what it tells your technicians about their tickets, and the alerts it raises for your team:

- **Domains about to expire** - an alert 45, 7 and 1 days before a domain expires
- **Ticket assigned - in the bell** and **Ticket assigned - by email** - what a technician gets when someone else assigns them a ticket or recurring ticket. Switch either off if your team doesn't want it - the ticket is still theirs, under **Mine**.
- **Client replies to agents helping** - the copy of a client's reply that goes to the technicians [helping](/service-desk/working-a-ticket#helpers) on a ticket. The technician it's assigned to is always emailed.
- **Email clients about their tickets** - the contact and watchers hear when a ticket is raised, scheduled, resolved and closed. Off, they still get the replies your agents send.
- **Email the invoices recurring invoices make** - off, they're made as drafts to check and send
- **Email a summary of the week** - for the owners, see [Weekly summary](#weekly-summary) below

Payment reminders and statements have their own schedule, in [Invoices and billing](/admin/billing#reminders-and-statements).

### Weekly summary {#weekly-summary}

Switch on **Email a summary of the week** for an email, early on the day you pick, on how the last seven days went beside the seven before: tickets opened and resolved, SLAs missed, good and not-good ratings, time logged and how much was billable, new clients and - with invoicing on - what was invoiced and paid, with your busiest clients. Under **Needs a look** it lists open tickets nobody has, overdue invoices, and domains and certificates running out in the next 30 days.

- **On** - the day it goes.
- **Send it to** - addresses, separated by commas. Leave it empty and every admin gets it.
- **Send me one now** sends you one for the last seven days, to see what it looks like. It's also under **Previews** in [Tests and previews](#tests-and-previews).

![The weekly summary email](adm-weekly-summary.webp "The weekly summary: the week beside the week before, and what needs a look")

It's sent by the nightly job, so cron needs to be running.

Once texting is set up, **Texts to clients** on the same page decides what ITFlow texts clients by itself - see [Text messaging](/admin/text-messaging#texts-to-clients).

![Notification settings](adm-notifications.webp "Notifications: the alerts your team gets, what technicians are told about their tickets, and the weekly summary")
