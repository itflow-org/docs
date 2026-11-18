---
title: Raising a ticket
description: Tickets come in by email and from the client portal, or you raise them yourself - from scratch or from a template that sets the whole ticket up.
where: Support > Tickets > New Ticket
---

Tickets reach ITFlow in several ways:

- **By email** - when your admin has set up email to ticket, an email to your support address becomes a ticket, and replies to ticket emails land on their ticket. See [Mail](/admin/mail).
- **From the client portal** - clients raise their own tickets, or fill in a request form. See [Tickets and requests](/portal/tickets).
- **On a schedule** - recurring tickets raise themselves. See [Recurring tickets](/service-desk/recurring-tickets).
- **From a project** - a project template raises its tickets. See [Projects](/service-desk/projects).
- **By you** - for a phone call, something you spotted, or work you're planning. For a call, [Quick ticket](#quick-ticket) is the fastest way.

## Raise a ticket

1. Click **New Ticket** - on the tickets list, a client's page, or the page of an asset, contact, location, vendor or service, which fills in what it can for you.
2. On **Details**:
   - Pick the **Client** and the **Contact** it's for. If they already have open tickets, ITFlow lists them, so you can add to one of those instead if it's the same problem.
   - Pick a **Template** if one fits (see below).
   - Type the **Subject** and the details.
   - Set the **Priority**, the **Category**, who to **Assign to**, and a **Due** date if it has one.
   - Pick the **Status** it starts in, if not the usual - it's New, or Open once it's assigned.
   - To book the work now, set the **Schedule** date and time, how long it takes, and **Remote** or **Onsite**. Leave it empty to book it later from the ticket.
   - Add **Tags**, and switch on **Mark Billable** if the client pays for this work.
3. On **Related**, link the **Asset** it's about (and **Other assets**), the **Site**, a **Project**, and a **Vendor** with **Their reference** if a vendor is involved. Add **Watchers** - people who get a copy of every emailed reply.
4. On **Tasks**, add the steps to work through.
5. Click **Create Ticket**.

![The New Ticket window](sd-new-ticket.webp "New Ticket: who it's for, what it's about, who's on it, and the status and schedule it starts with. Open tickets for the contact show at the top.")

The contact gets an email saying their ticket is raised, when client emails are on, and the technician you assigned it to is told. Work you scheduled is booked as it is from the ticket's **Schedule** window: the technician, and the contact and watchers when client emails are on, get the time with a calendar invite - see [Book a visit or a call](/service-desk/working-a-ticket#book-a-visit-or-a-call).

## Quick ticket {#quick-ticket}

For a call, or someone at your desk, click **+** in the top bar - it's there on every page. **Quick ticket** asks only for what you need while they're talking.

1. Pick the **Client** - on a client's page, it starts on that client - and the **Contact**. It starts on the client's primary contact. To find someone else, type their name, email address or phone number.
2. If the contact already has open tickets, they're listed, with who has each one. If it's the same problem, click **Work on this one** to go to that ticket instead, with its timer running.
3. Type **What is the issue?**, and any **More detail**.
4. Set the **Priority**, and leave **Assign it to** on to give it to the person shown - usually you.
5. Click **Make ticket**.

![The Quick ticket window](sd-quick-ticket.webp "Quick ticket: the client, the contact and their open tickets, and the issue")

The ticket opens with its timer already running, ready for your notes. Your admin sets what a quick ticket starts with - who it goes to, its status, category and billing, when its timer starts, and whether the contact is emailed - in [Ticket settings](/admin/tickets#quick-tickets).

## Start from a template

A ticket template sets up a whole ticket for a job you do often: the subject and details, the tasks, the category, priority, who it goes to, when it's due, its tags and whether it's billable. Your admin makes them in [Ticket and project templates](/admin/ticket-templates).

Click **Template** and pick one. The list says what each template sets up and how many tasks it has. Picking it fills in the form, so you see the ticket before it's made and can change anything.

![The template picker listing templates with their tasks, fill-ins, priority, category and due time](sd-template-picker.webp "The template picker says what each template sets up")

### Placeholders

Words in square brackets are filled in when the ticket is made:

| Placeholder | Becomes |
|---|---|
| `[Client]`, `[Contact]` | The client's and contact's names |
| `[Asset]`, `[Site]` | The ticket's asset and site |
| `[Agent]` | The technician it's assigned to |
| `[Project]`, `[Ticket]` | Its project and its ticket number |
| `[Date]`, `[Month]`, `[Quarter]`, `[Year]` | When it's raised, such as "November 2026" or "Q4 2026" |

### Fill-ins

Any other word in square brackets - `[Employee Name]`, `[Start Date]` - is a **fill-in**: something the template asks for. When you pick the template, a box for each one appears at the top of the form. Your answers go wherever their name is in the subject, details and tasks.

![The New Ticket window after picking New Hire Onboarding, asking for the employee's name, start date, job title and more](sd-template-fillins.webp "New Hire Onboarding asks for what it needs; each answer goes into the subject, details and tasks")

- A fill-in marked with a red star must be answered.
- Some are dates, some are yes or no, some are a choice from a list.
- Some tasks only apply to one answer. On New Hire Onboarding, "Order the computer" is only kept when **Needs a Computer** is Yes, and "Configure the phone extension and voicemail" when **Needs a Phone Extension** is Yes. Tasks for other answers drop out as you answer.
- Leave one blank if you don't know it yet. It stays in the text as `[Copy Access From]`, and can be answered on the ticket later.

The answers stay on the ticket in its **Fill-ins** card. See [Working a ticket](/service-desk/working-a-ticket#fill-ins).

## Raise the same ticket for many

To raise one ticket each for several clients or assets - a patch round, a quarterly check - tick them on the **Clients** or **Assets** list and use **Bulk Action > Create Tickets** (or **Open Tickets** on the clients list). The window offers templates and asks their fill-ins once, for all of the tickets. On the clients list, each ticket can go to the client's primary contact.
