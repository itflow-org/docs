---
title: Tickets, statuses and SLAs
description: How tickets are numbered, made from email, billed and closed; your own ticket statuses; and SLA targets with business hours and holidays.
where: Admin > Settings > Tickets, Admin > Ticket Statuses, Admin > SLAs
access: Admins
---

## Ticket settings

**Admin > Settings > Tickets** sets how tickets work for everyone.

![Ticket settings](adm-ticket-settings.webp "Ticket settings: numbering, email to ticket, who hears about new tickets, billing and closing")

- **Numbering** - the **Prefix**, such as `TCK-`, and the **Next number**.
- **New tickets** - **Email new tickets to** a shared mailbox or list, so someone always sees them come in. **Triage new tickets with AI** gives tickets from email, the portal and the API a category and priority as they arrive - see [AI](/admin/ai).
- **Time and billing** - **Start the timer on opening a ticket**, and whether **New tickets are billable**. How the time is billed is in [Invoices and billing](/admin/billing#billing-time).
- **Closing** - **Close resolved tickets after** so many hours. A resolved ticket waits for the client to say it isn't fixed, then closes itself overnight. 72 hours is three days.
- **The tickets page** - whether **Tickets open as** a list or the board, and whether agents can order tickets by hand on the board and rearrange its columns.

### Email to ticket {#email-to-ticket}

Switch on **Turn emails into tickets**, and an email to your support mailbox becomes a ticket, and a reply goes onto its ticket. The mailbox is set up in [Mail](/admin/mail#receiving).

Email from someone who isn't a contact, at a domain no client has, is left in the mailbox, flagged and unread - unless you switch on **From unknown senders too**.

## Ticket statuses

Tickets move through **New**, **Open**, **On Hold**, **Resolved** and **Closed**. Under **Admin > Ticket Statuses** you can add your own between them - "Waiting on Vendor", "Scheduled", "Parts on Order".

![Ticket statuses](adm-statuses.webp "Ticket statuses: the built-in ones and your own, with their tickets, SLA clock and what a client's reply does")

Each status shows as its badge, with what it's for, how many tickets are in it (click to see them), whether the SLA clock runs or pauses in it, and what a client's reply does. Drag the statuses into the order the status pickers and the ticket board show them in, or use **Move up** and **Move down** on a status's menu.

ITFlow's five are marked **Built in**. They keep their names and stay switched on, and their SLA clock and what a reply does are fixed - their window says what each does and when ITFlow sets it. Their colour and description can change.

### Add or change a status

Click **New Status**, or **Edit** on a status's menu.

![The window for the Scheduled status](adm-status-form.webp "A status: its badge, colour, SLA clock and what a client's reply does")

- **Name**, and a **Description** that shows when someone points at the status - in the pickers, on the board and on tickets.
- **Color** - pick a swatch or any colour. **Looks like** shows the badge; its text turns dark or white, whichever reads on the colour.
- **SLA resolution clock** - **Keeps running**, or paused. A ticket in a paused status never warns or breaches on resolution; the time already spent is kept, and the deadline moves out when the ticket comes back. Pause it for statuses where you're waiting on someone else. The response clock always runs.
- **When the client replies** - **Move it back to Open**, as a reply always has, or **Leave it in this status**. Leave it for a status like Scheduled, where "thanks, see you then" shouldn't put the ticket back in the queue. It's the same by email or in the portal, and whoever the ticket is assigned to is told either way.

### Switch off or delete a status

**Switch off** takes a status out of the pickers and off the board, but keeps it. Its tickets can be moved to another status first, or left where they are. Switch it on again from the **Switched off** tab.

**Delete** moves its tickets to the status you pick first. Each ticket's history says so, and its SLA clock follows the new status. Canned responses that set the deleted status leave the status as it is instead.

## SLAs

SLAs are optional. With none assigned, tickets have no targets. **Admin > SLAs** has three parts.

![SLAs](adm-sla.webp "SLAs: the targets, which tickets get them, your business hours and holidays")

**The SLAs** - each has a **Response target** and a **Resolution target**, in business minutes: "Standard Support - 4 hours to respond, 2 days to resolve", "Critical Response - 30 minutes to respond".

**SLA assignments** - which SLA a ticket gets by its priority: Low, Medium, High and Urgent. The defaults apply to every client; set a client's own on that client's Edit window, for a contract with different terms.

**Business hours and notifications** - your **Business days**, and when the working day starts and ends. SLA clocks only run in business hours. **Warn at % of target** sends a warning before a target is missed, and **Notification email** sends warnings and breaches to a shared address as well as the assigned agent.

**Holidays and closure days** - days the office is shut, when SLA clocks stop. **Add US Holidays** adds a year's US public holidays in one go.

On a ticket, the SLA shows how long is left to respond and to resolve. See [Working a ticket](/service-desk/working-a-ticket#slas). The SLA reports show how well you're keeping to them.
