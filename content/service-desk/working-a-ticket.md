---
title: Working a ticket
description: The ticket page - replying to the client or your team, logging time, working through tasks, booking a visit, and resolving it when the job's done.
where: Support > Tickets > a ticket
---

Click a ticket to open its page. On the left is the conversation and the reply box. On the right is everything you need to work it: its details, who it's for, where they are, its tasks and what's linked to it.

![A ticket's page: the header, description, reply buttons and conversation on the left, details, contact and site on the right](sd-ticket.webp "A ticket's page")

## The header

At the top: the ticket number, the client and contact, the subject (click the pencil to edit the ticket), where it came from, and its tags. If someone else on your team has the ticket open, it says so here, so you don't both reply.

On the right is the one action for where the ticket is:

- **Resolve** while it's open. If the ticket has tasks, they must all be done first.
- **Reopen** and **Close** once it's resolved.
- **Invoice** once a billable ticket is done.

The **⋮** menu has the rest: **Log a trip**, **Merge into another ticket**, **Move to another client**, **Copy as a new ticket**, **Apply a template**, **Create quote**, **Create invoice** and **Delete ticket**. With AI set up, it also has **Summarize with AI**, **Triage with AI** and **Write up as a document** - see [Using AI](/getting-started/ai). **Write up for the Knowledge Base** starts a draft article from the ticket - see [Knowledge Base](/service-desk/knowledge-base#write-up).

![The ticket's menu](sd-ticket-menu.webp "The ticket's ⋮ menu")

## Details

The **Details** card shows where the ticket stands. Click a value to change it.

![The Details card: status, priority, assigned to, SLA, category, scheduled, billing and time logged](sd-ticket-details.webp "Details: click any value to change it")

- **Status** - New, Open, On Hold, and any statuses your admin added, such as "Waiting on Vendor". Some statuses pause the SLA clock.
- **Priority** - Low, Medium, High or Urgent.
- **Assigned to** - the technician working it. They're told when you change it.
- **Additional agents** - other technicians helping, each with their booking. See [Get help from another technician](#helpers).
- **SLA** - the next target and when it's due, or **Breached** once it's missed. See [SLAs](#slas) below.
- **Category**, **Scheduled** (see [Book a visit](#book-a-visit-or-a-call)), **Billing** and **Time logged**.

## Reply to the client or your team {#reply}

Above the conversation are the reply buttons. Nothing is picked for you, so who sees a reply is always your choice:

| Button | Who sees it |
|---|---|
| **Internal note** | Only your team. For notes, findings and handovers. |
| **Public note** | The client, in the client portal. No email is sent. |
| **Email reply** | The people in its **To** line, by email - the contact and the ticket's watchers to start with - and it shows in the portal. Only there when mail is set up and the contact has an email address. |
| **Text reply** | The contact, by text to their mobile, and it shows in the portal. Only there when [text messaging](/admin/text-messaging) is set up and the contact has a mobile number - or someone who isn't a contact is texting on the ticket. |

Pick one and the reply box opens, with a line saying exactly who will see it. An email reply carries the conversation so far, as short excerpts, and a link to the ticket that opens without signing in - see [The ticket link in emails](/portal/tickets#ticket-link).

![The reply box with Email reply picked](sd-reply.webp "The reply box: who will see it, the To line, the editor, files, the time worked and when, and the status after it")

1. Type your reply. To use a canned response, click **Canned response** or type <kbd>/</kbd> in the reply. See [Canned responses](/service-desk/canned-responses). To send a how-to, click **Knowledge Base** - see [Knowledge Base](/service-desk/knowledge-base#tickets).
2. Add files under **Attach files** if you need to, or drop them onto the reply box.
3. Pick the **Status after this** - for example, set it to On Hold while you wait for a part.
4. Enter the **Time worked**, or click ▶ to start a timer and let it count while you work. **+15m**, **+30m** and **+1h** add time in one click - the timer stops at the new total. **When it was worked** fills in from the timer - the work ends now - or type the date, start and end yourself. See [When the time was worked](#work-times).
5. Click the button: **Add note** for an internal note, **Post note** for a public note, **Send email** for an email reply. Your signature is added to email replies.

On a billable ticket, a reply with no time asks first: **Send without time**, or **Add time** to go back and enter it.

What you type is kept as you write. Leave the page, close the browser or get signed out, and it's still in the reply box next time, with a note saying so - pick who it's for to carry on, or **discard it**. Sending it clears it, and one left untouched for a month goes.

Once an email reply is sent, the message at the top says how many people it went to. If nobody got it - the ticket has no contact or watcher with an email address, or mail isn't set up - it says so, and the reply is kept as a public note.

### When the time was worked {#work-times}

A note with time on it keeps when the work was done, beside the time in the conversation - "25m (Tue Nov 17, 2:05 - 2:30 PM)".

- Until you type them, the date, start and end follow the timer: the work ends now, and started the time worked ago.
- Type a start and end - for a visit this morning, or a call you're writing up later - and the time worked follows them. Typing pauses the timer. **Use the timer** goes back to it.
- After typing the times, changing the time worked moves the start - the end stays.
- An end before the start runs past midnight - 11:30 PM to 12:45 AM is an hour and a quarter.

A note with time worked won't send without a date, start and end. Times are your company's time zone.

### Timers in the top bar {#timers}

A ticket's timer keeps counting when you go to another page. While any ticket has time on its timer, a stopwatch shows in the top bar, with how many - it pulses while one is running. Click it to see each ticket and its time.

![Ticket timers in the top bar](sd-ticket-timers.webp "Ticket timers: one running, one paused")

- Click a ticket to go back to it and log the time.
- **Pause** or **Resume** a timer from here.
- The bin throws a timer's time away, after you confirm - for time that shouldn't go on the ticket.

Timers are kept in your browser, so the list shows the ones in this browser on this computer.

### Who an email reply goes to {#email-to}

**Email reply** adds a **To** line above the reply. It starts with the contact, the watchers, and anyone at the client who asked for every update on their company's tickets.

- Click the line to add the technician the ticket is assigned to or another of the client's contacts, or type an email address and press <kbd>Enter</kbd>.
- Click **×** on anyone who shouldn't get this reply.
- Everyone in To gets the email, each told why they're getting it.
- What you change is kept for the ticket, so its next email reply starts with the same people. Taking a watcher out of To doesn't stop them watching - they still get the ticket's other emails.

A reply won't send with nobody in To, or with something in it that isn't an email address - pick **Public note** to post it without an email. A reply sent to several tickets at once with [Reply or add a note](/service-desk/tickets#bulk-reply) still goes to each one's contact and watchers.

> [!TIP]
> If you try to leave the page with a reply half written, ITFlow asks first.

### Mention someone on your team {#mention}

In an internal note, type **@** to bring someone on your team in. A list of the agents who can open this ticket comes up, and narrows as you type a name or role. Click one, or press <kbd>Enter</kbd>, and their name goes into the note.

![Typing @jo in an internal note, with Jordan Lee offered](sd-mention-picker.webp "Type @ in an internal note and pick who to mention")

When you add the note, everyone it mentions is told:

- in ITFlow - a notification that opens the ticket at your note
- by email, from the ticket mailbox, with your note and the ticket's details

The message at the top says who was told, and the ticket's history keeps it.

On the ticket, a note that mentions you says **Mentions you**, and your name in it is picked out. **Mentioned me** on the [tickets list](/service-desk/tickets#views) shows the open tickets you've been mentioned on.

![An internal note that mentions you](sd-mention-note.webp "A note that mentions you, as you see it")

- Mentions are for internal notes only. In a public note or an email reply they're plain text and nobody is told - the reply box says so if you switch with a mention in it.
- Only agents who can open the ticket are offered: someone whose role has no access to tickets, or who is kept away from this client, isn't on the list.
- Editing a note tells anyone you add to it, and nobody twice. Take someone out, or archive the note, and it no longer counts as mentioning them.

### The conversation

Replies are listed newest first. Client replies are marked **From client**, and **By text** when they texted it. Yours are marked **Internal**, **Public note**, **Email reply** or **Text reply**, and each shows the time logged with it. A text reply says who it was texted to and whether it went. A note that [mentions you](#mention) also says **Mentions you**. Use **All**, **Public** and **Internal** above the conversation to filter it.

An email reply also says who it was emailed to - **Emailed to Priya Raghavan and 1 more**. Click that to see each person and where their email stands:

![An email reply, with who it went to](sd-reply-emailed.webp "An email reply: who it was emailed to, and whether each email was sent")

- **Sent** - and when
- **Waiting** or **Retrying** - still in the [mail queue](/admin/mail#the-mail-queue). Until they've gone, the reply says **Sending to**.
- **Failed** - with why, such as an address that doesn't exist. The reply says **Couldn't email** when nobody got it, or how many weren't sent.
- **Cancelled** - someone stopped it in the mail queue

Admins also get a link to the ticket's email in the mail queue, to retry one that failed. The mail queue keeps email for 90 days, so after that the reply still says who it went to, but no longer whether each one went.

Replies from before ITFlow kept this are marked **Public**, as it isn't known whether they were emailed - unless the mail queue still had their email when you updated, in which case they show as email replies too.

Click a picture that's been shrunk to fit to see it full size. Click again, or press <kbd>Esc</kbd>, to close it.

A reply that came in by email keeps the email as it arrived, as **Original-parsed-email.eml** under it - and so does a ticket raised by email. **Read** beside it shows who it was from and to, when, its headers, and everything it said, including what ITFlow trimmed off below the reply line. **Download .eml** opens it in your email app.

Each reply's **⋮** has **Edit**, **Redact** (to blank out something that shouldn't be kept, such as a password the client sent) and **Archive**. Editing an email reply changes it on the ticket and in the portal - the people it was emailed to keep the email as it was sent.

A client's reply also has **Split into a new ticket** - for when they raise a second problem in a reply. Give it a subject, and pick its priority and who it's assigned to. The new ticket is for the same client and the person who wrote the reply, with what they wrote as its details and their attachments. The reply leaves this ticket, and a note on each ticket points to the other. The client is told about the new ticket as for any other.

**Edit** changes a note's time and when it was worked too: change the times and the time worked follows, or change only the time worked and the start moves. Notes from before this, and from bulk replies and the API, ended when they were posted.

## Contact, site and vendor

- **Contact** - who the ticket is for, with their phone numbers and email. Click the pencil to change the contact.
- **Site** - the location's address, phone, opening hours and access notes, with directions.
- **Also open** - the client's other open tickets, in case they're about the same thing.
- **Trips** - the driving done for the ticket, for onsite work. See [Trips and mileage](/billing/trips).

## Tasks

Tasks are the steps to the job. They come from the ticket's template, or you add them - or apply a template to a ticket that's already open, from the **⋮** menu (see [Copy a ticket or apply a template](#copy)):

- Type in **Add a task** and press <kbd>Enter</kbd>.
- Tick a task when it's done. Drag tasks by their handle to reorder them.
- A task's **⋮** has **Require approval**: the task waits until someone approves it - **Our team** (a technician you pick) or **The client** (a contact, who approves it in the client portal or by email).
- The menu on the card has **Mark all complete** and **Mark all incomplete**.

The ticket can't be resolved until its tasks are done.

## Linked records

The **Linked** card shows what the ticket is about and who's on it:

![The Linked card: assets, the vendor with their ticket number and support details, the project, services and watchers](sd-ticket-linked.webp "Linked: the asset, the vendor's case, the project, the services it affects and the watchers")

- **Assets** - the devices the ticket is about.
- **Vendor** - when a vendor is involved, their case number (**Their ticket**), support line, hours and SLA, account number and PIN, email and site, each with a copy button.
- **Project** - the project it's part of, with its progress.
- **Services** - the client services it affects, directly or through its asset.
- **Watchers** - extra people copied on every emailed reply, such as the client's IT contact.

Use the **+** on the card to **Change assets**, **Change vendor**, **Change project**, **Link a service** or **Add watcher**.

## Fill-ins

A ticket raised from a template that asks questions has a **Fill-ins** card with the answers. A question left blank shows as **Not answered**: click the pencil to answer it, and the answer goes into the ticket's text wherever it's still waiting.

![A ticket raised from New Hire Onboarding, with its Fill-ins card and the tasks for the answers given](sd-ticket-template.webp "A ticket from a template: the answers in its Fill-ins card, and the tasks for those answers")

## Book a visit or a call

Click **Scheduled** in the Details card, pick the **Date and time**, **How long** it takes - an hour unless you pick otherwise - and whether it's a **Remote** or **Onsite** visit. **Agent** is who does it: picking someone else gives them the ticket, and the agent who had it is emailed that it's off their calendar. Under the fields is that agent's day, so you can see when they're free. If they already have a ticket or an event at that time, ITFlow books it anyway and tells you what overlaps.

![The Schedule window](sd-ticket-schedule.webp "Schedule: the date and time, the agent, how long, remote or onsite - and the agent's day")

If you've set **My time zone** in [your preferences](/getting-started/account#preferences), the time you pick, and the booking on the ticket, are on your own clock - ITFlow keeps it in the company's time for the client and everyone else.

The contact, the watchers and the assigned technician are emailed the start and end, with a calendar invite, and the ticket shows on the [calendar](/service-desk/calendar) for that long. Changing or cancelling it tells them the same way. A contact who agreed to texts is texted the time too, and reminded before it - see [Texts to clients](/admin/text-messaging#texts-to-clients).

## Get help from another technician {#helpers}

A ticket can have more than one technician on it. The one it's **Assigned to** stays the lead; the others help.

1. In the **Details** card, click **Add an agent** under **Additional agents**.
2. Pick the **Agent** - anyone who can open the ticket.
3. Under **When**, pick **Same time as the lead** (it moves, and is cancelled, with the lead's booking), **A time of their own** - with the **Date and time** and **How long**, and their day underneath - or **Not booked**.
4. Click **Add**.

![The Add an agent window](sd-ticket-helper.webp "Add an agent: who, and when - with the lead, a time of their own, or not booked")

They're emailed their booking with a calendar invite of its own, so it never replaces the lead's - or, when they aren't booked, that they're on the ticket. A helper finds the ticket under **Mine** and on their dashboard, has their booking on the [calendar](/service-desk/calendar) and in their calendar link, and is emailed the client's replies as the lead is. The client is only ever told about the lead's booking.

Click a helper in the **Details** card to change their booking, or **Take off** to take them off the ticket - a booking they had is cancelled, and they're emailed the cancellation. If a helper becomes the one it's assigned to, they're the lead from then on.

## Resolve and close

When the work is done, click **Resolve**. ITFlow:

- emails the contact that it's resolved (when client emails are on), with a button to reopen it if it isn't fixed
- closes it by itself after a set time - your admin picks how long - unless the client replies, which reopens it

A resolved ticket is reopened by **Reopen**, or by a reply that sets a working status such as Open. Either way its resolution SLA starts again.

Click **Close** to close it straight away. Closing is final: a closed ticket can't be reopened. Clients are asked how you did when a ticket closes.

### When the client never answers {#no-response}

For a client who hasn't replied after several tries, use the arrow beside **Resolve** and pick **Resolve - no response**. The window has your admin's message for this, filled in for the ticket - change it if you like, then click **Send and resolve**.

- The message goes on the ticket as a public note, and to the contact and watchers in place of the usual "resolved" email, when client emails are on.
- The ticket is resolved, and closes on its own as usual - without asking the client how you did.
- If they reply before it closes, it reopens like any resolved ticket.

## Copy a ticket or apply a template {#copy}

- **Copy as a new ticket** opens **New Ticket** with this ticket's subject, details, priority, category, billing, contact, asset and tasks, for the same client. Change anything first - pick another client for the same job somewhere else.
- **Apply a template** puts a ticket template on a ticket that's already open. Pick the template: its tasks are listed for you to change, and it asks its [fill-ins](/service-desk/new-ticket#fill-ins). **Apply** adds the tasks after the ticket's own, and its tags and due time where the ticket has none. The ticket's subject, details, category and priority stay as they are.

## Merge, move and delete

- **Merge into another ticket** - when two tickets are about the same thing. Pick the ticket to keep and give a reason; this ticket is closed and can move its replies across, with their attachments.
- **Move to another client** - for a ticket raised under the wrong client. Watchers who aren't on your team or contacts at the new client come off it, and its [To line](#email-to) starts again. The links to the ticket, and to its task approvals, already emailed to the old client stop working - the new client gets a working link with the next email.
- **Delete ticket** - only for tickets raised by mistake. Normally resolve or close them instead.

## Billing a ticket

Set **Billing** in the Details card to **Billable** for work the client pays for. Once it's resolved, the ticket waits in [Unbilled time](/billing/unbilled-time) with everything else to bill - or click **Invoice** on the ticket to bill it on its own. The Invoice window shows the time each technician logged, the hours that bills, and the rate - the client's contract's, or your default. **Create quote** in the menu starts a quote from the ticket, for work that needs agreeing first.

## SLAs

An SLA (service level agreement) sets how fast you reply to and fix tickets, by priority - for example, an Urgent ticket gets a first response within an hour and is fixed within four. A ticket gets the SLA the client's [contract](/billing/contracts#in-force) sets for its priority, or your default.

The ticket's **SLA** row shows the next target: **First response due in 2 hours**, then the resolution target once you've replied where the client can see it. Internal notes don't count as a response - but moving the ticket into a status your admin set to [count as the first response](/admin/tickets#first-response) does, such as "Assigned". A status that pauses the SLA, such as On Hold, stops the clock. When a target is close, the ticket turns amber; once it's missed, it shows **Breached**, and the SLA alert address and the technician are emailed. Your admin sets SLAs up in [Tickets, statuses and SLAs](/admin/tickets).
