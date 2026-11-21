---
title: Tickets, statuses and SLAs
description: How tickets are numbered, made from email and texts, billed and closed; your own ticket statuses; and SLA targets with business hours and holidays.
where: Admin > Settings > Tickets, Admin > Ticket Statuses, Admin > SLAs
access: Admins
---

## Ticket settings

**Admin > Settings > Tickets** sets how tickets work for everyone.

![Ticket settings](adm-ticket-settings.webp "Ticket settings: numbering, email to ticket, who hears about new tickets, billing and closing")

- **Numbering** - the **Prefix**, such as `TCK-`, and the **Next number**.
- **New tickets** - **Email new tickets to** a shared mailbox or list, so someone always sees them come in. **Triage new tickets with AI** gives tickets from email, the portal and the API a category and priority as they arrive - see [AI](/admin/ai).
- **Assigning** - **Assign an unassigned ticket to the first agent to reply**: on, a technician who replies to a ticket nobody has - with a public note, an email reply or a text reply - is assigned it, just as **Assign to me** would. An internal note doesn't assign it, and a ticket that's already assigned keeps its technician. Switch it off if, say, someone answers new tickets before handing them on.
- **Time and billing** - **Start the timer on opening a ticket**, and whether **New tickets are billable**. How the time is billed is in [Invoices and billing](/admin/billing#billing-time).
- **Quick tickets** - what a ticket raised with the **+** in the top bar starts with - see [Quick tickets](#quick-tickets) below.
- **Messages to clients** - the **"Ticket assigned" message**, sent when a ticket moves into a status that [counts as the first response](#first-response) by emailing the client, and the **"Resolve - no response" message**, for a client who never answered - see [Working a ticket](/service-desk/working-a-ticket#no-response). Agents can change that one for each ticket before it goes. Words in square brackets are filled in from the ticket, as in canned responses - `[Ticket]`, `[Subject]`, `[First Name]`, `[Agent]` (who it's assigned to - or, for no response, who sends it) and the rest. The email greets each person by name, so the message needn't. Empty, the built-in wording is used.
- **Closing** - **Close resolved tickets after** so many hours. A resolved ticket waits for the client to say it isn't fixed, then closes itself overnight. 72 hours is three days.
- **The tickets page** - whether **Tickets open as** a list or the board, and whether agents can order tickets by hand on the board and rearrange its columns.

### Email to ticket {#email-to-ticket}

Switch on **Turn emails into tickets**, and an email to your support mailbox becomes a ticket, and a reply goes onto its ticket. The mailbox is set up in [Mail](/admin/mail#receiving).

Email from someone who isn't a contact, at a domain no client has, is left in the mailbox, flagged and unread - unless you switch on **From unknown senders too**.

#### Try an email {#try-an-email}

To see what an email would become before anyone sends one, click **Try an email**. Type who it's **From** and its **Subject** - a reply to one of your emails has the ticket number in brackets, like `[TCK-123]` - and switch on **It's an automatic reply** for an out-of-office answer. **Try it** goes through what the mailbox asks, in order, and says where it ends up:

- an automatic reply is skipped
- a ticket number in the subject - a reply on that ticket: the client's reply from its contact or another of the client's contacts, a technician's own note, a watcher's note, or a note with a warning from a stranger, which doesn't reopen it. A closed ticket isn't reopened, and the sender is told.
- the same subject as an open ticket of theirs from the last week - a reply on that ticket
- a contact's address - a new ticket for their client
- an address at a client's domain - a new contact, and their ticket
- anyone else - a ticket with no client, when unknown senders are let in, or left in the mailbox

![Trying an email](adm-ticket-mail-try.webp "Try an email: each step the mailbox takes, and where the email ends up")

Nothing is made or sent - it uses your saved settings and the contacts, domains and tickets you have now.

### Text to ticket {#text-to-ticket}

Once [text messaging](/admin/text-messaging) is set up, a text from one of your contacts - from their mobile or phone number - opens a ticket for them. What they text next goes on it as their reply, with any photos attached, and opens it again if it was resolved. A text about a ticket that's being texted on goes on that ticket for two weeks after the last text, while it's open.

- **Turn texts into tickets** - on to start with. Off, every text waits in [Texts](/service-desk/texts) for an agent. STOP, START and HELP are still answered.
- **From unknown numbers too** - a text from a number that isn't a contact's opens a ticket with no client. Off, those wait in Texts, where an agent opens a ticket from one. Verification codes and spam wait there either way.
- **Text back the ticket number** - the first text of a new ticket is answered with its number, so they know it landed and that replying adds to it.

### Quick tickets {#quick-tickets}

The **+** in the top bar opens [Quick ticket](/service-desk/new-ticket#quick-ticket), for a call or a walk-up. Here you set what those tickets start with:

- **Show the Quick ticket button** - for everyone who can make tickets.
- **Quick ticket goes to** - the agent making it, nobody, or one agent. The window has a switch to change it for one ticket.
- **Quick ticket starts in** - a status, or New (Open once someone has it), as usual.
- **Quick ticket priority**, **Quick ticket category** and **Quick ticket billing** - billing follows **New tickets are billable** unless you pick one here. The window can change the priority.
- **Start a quick ticket's timer** - when the agent clicks **Create**, from when they opened the window (the start of the call), or not at all.
- **Start on the client's primary contact** - off, the contact starts empty.
- **Show the contact's open tickets** - so the same problem isn't raised twice.
- **Email the contact that it was opened** - the "ticket created" email, as from New Ticket, when emails to clients are on.

## Ticket statuses

Tickets move through **New**, **Open**, **On Hold**, **Resolved** and **Closed**. Under **Admin > Ticket Statuses** you can add your own between them - "Waiting on Vendor", "Scheduled", "Parts on Order".

![Ticket statuses](adm-statuses.webp "Ticket statuses: the built-in ones and your own, with their tickets, SLA clock and what a client's reply does")

Each status shows as its badge, with what it's for, how many tickets are in it (click to see them), whether the SLA clock runs or pauses in it, and what a client's reply does. Drag the statuses into the order the status pickers and the ticket board show them in, or use **Move up** and **Move down** on a status's menu.

ITFlow's five are marked **Built in**. They keep their names and stay switched on, and their SLA clock is fixed - their window says what each does and when ITFlow sets it. Their colour and description can change, and so can where a client's reply moves a ticket in one - back to Open, or a status of your own - though a reply never leaves it where it is. A closed ticket can't be replied to.

### Add or change a status

Click **New Status**, or **Edit** on a status's menu.

![The window for the Scheduled status](adm-status-form.webp "A status: its badge, colour, SLA clock, what a client's reply does and whether it counts as the first response")

- **Name**, and a **Description** that shows when someone points at the status - in the pickers, on the board and on tickets.
- **Color** - pick a swatch or any colour. **Looks like** shows the badge; its text turns dark or white, whichever reads on the colour.
- **SLA resolution clock** - **Keeps running**, or paused. A ticket in a paused status never warns or breaches on resolution; the time already spent is kept, and the deadline moves out when the ticket comes back. Pause it for statuses where you're waiting on someone else. The response clock always runs.
- **When the client replies** - **Move it back to Open**, as a reply always has, **Leave it in this status**, or **Move it to** another status. Leave it for a status like Scheduled, where "thanks, see you then" shouldn't put the ticket back in the queue. Move it to a status such as "Client responded" - set on Open and On Hold too - and the tickets with a new answer from the client stand out on the list and the board. It's the same by email, in the portal or by text, and whoever the ticket is assigned to is told either way. If the status it moves to is switched off, the reply moves the ticket back to Open.
- **Counts as the first response** - see below. Not for New, Resolved or Closed.

### A status that counts as the first response {#first-response}

Usually only a reply the client sees answers a ticket and meets the SLA's [response target](#slas). A status can count too - an "Assigned" status, say, that your team moves a ticket into as they pick it up:

- **Yes - without an email** - moving a ticket into it counts as the first response, and nothing is sent.
- **Yes - after emailing the client that it is assigned** - the contact and watchers are emailed the **"Ticket assigned" message** from [ticket settings](#ticket-settings) first, and it's kept on the ticket as a public note. If nobody could be emailed - no address, no mail set up, or client emails off - it doesn't count, and the ticket's history says so.

It counts once, for a ticket nobody has answered yet, when an agent moves it into the status: setting the status by hand or in a reply, or assigning a new ticket, which moves it to Open. A client's own reply moving a ticket never counts.

### Switch off or delete a status

**Switch off** takes a status out of the pickers and off the board, but keeps it. Its tickets can be moved to another status first, or left where they are. With none moved, **Undo** on the message switches it back on. Switch it on again later from the **Switched off** tab.

**Delete** moves its tickets to the status you pick first. Each ticket's history says so, and its SLA clock follows the new status. Canned responses that set the deleted status leave the status as it is instead.

## SLAs

An SLA sets how long there is to first reply to a ticket and, if you like, how long to resolve it. SLAs are optional: with none, tickets have no targets and nothing else about them changes. **Admin > SLAs** lists your SLAs, with the default for each priority and your business hours beside them.

![SLAs](adm-sla.webp "SLAs: each SLA's targets and what uses it, with the default for each priority and your business hours beside the list")

Each SLA shows its **Response** and **Resolution** targets, the priorities it's the default for, and what uses it: open tickets, contracts and contract templates. Search the list, click a heading to sort by it, and use the tabs for the **Active** and **Archived** SLAs. The other two tabs are your [closure days](#closure-days).

Targets are business time: a clock only runs in your business hours. So the list says what each target comes to. With a 9 to 5 day, a 4-hour target given at 4 PM runs out at noon on the next business day, and a 48-hour target is **6 business days** - shown with the 48 hours under it. With no business days picked, the clocks run around the clock and 48 hours is two days.

**On tickets now**, under the list, counts the open tickets with an SLA, those close to a target and those that have missed one. Click either of the last two to see the tickets. The **SLA Performance** and **SLA by Client** [reports](/finance/reports), on the menu beside **New SLA**, show how often targets were met.

On a ticket, the SLA shows how long is left to respond and to resolve. See [Working a ticket](/service-desk/working-a-ticket#slas).

### Add or change an SLA

Click **New SLA**, or an SLA's name.

![The window for Standard Support](adm-sla-form.webp "An SLA: its name, and how long there is to reply and to resolve, in hours and minutes")

- **Name** and **Description** - "Standard Support", "Critical Response".
- **Response target** - how long there is to first reply to a new ticket, in hours and minutes.
- **Resolution target** - how long there is to resolve it. Leave it empty for an SLA that only times the first reply. It can't be shorter than the response target.

The window says what a day's worth comes to with your hours: with an 8-hour business day, 24 hours is 3 business days, so for two business days give 16 hours. Saving a change works the targets out again on every ticket with the SLA that isn't closed yet.

**Archive**, on an SLA's menu, takes it out of use: new tickets don't get it, and tickets that have it keep their targets. A priority it was the default for gets no SLA until you pick another, and tickets under a contract that gave it get your default for their priority instead. **Undo** on the message after puts it back; later, **Restore** it from the **Archived** tab. An SLA can't be deleted.

### Default SLA by priority {#default-slas}

Pick the SLA for **Low**, **Medium**, **High** and **Urgent** tickets - or **No SLA** - and click **Save**. A client has no SLAs of its own: a new ticket gets the SLA its client's [contract](/billing/contracts#in-force) sets for its priority, and the default for a priority the contract leaves empty, or when the client has no contract in force. Saving looks again at every ticket that isn't closed yet.

### Business hours and alerts {#business-hours}

- **Business days** and **Business hours** - the days you work, and when the day starts and ends, in your company's time zone. SLA clocks only run then. Pick no days for cover around the clock.
- **Warn at** - how far through a target a ticket's agent is warned: 75% to start with. They're told again if the target is missed, in ITFlow and by email.
- **Also email** - a shared address that gets every warning and missed target as well.

Saving works the targets out again on tickets that aren't closed yet. The warnings are sent by [cron](/admin/maintenance#cron), and the card says so if it isn't running. These are also the hours a contract's [after-hours rate](/billing/contracts#in-force) goes by.

### Holidays and closure days {#closure-days}

The **Closure days** tab lists the days the office is shut - public holidays, or any other day. No SLA clock runs on a closure day, the same as a day outside your business days.

![Closure days](adm-sla-days.webp "Closure days: each with its date and how far off it is")

- **New Closure Day** adds one: its **Date**, and a **Name** for it.
- **Add US holidays**, on the menu beside it, adds the eleven US federal holidays for the year you pick, each on the day it's observed. The window says how many of each year's are already in, and a day already on the list is left as it is.
- The bin removes a day, after asking.

Search by name, date, month or day of the week, and click a heading to sort. A day that falls on one you're shut anyway says so. Days gone by move to **Past closure days**. Adding or removing a day works the targets out again on tickets that aren't closed yet.
