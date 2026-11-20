---
title: Projects
description: Group the tickets for a bigger job - a server replacement, an office move, onboarding a new client - and track them against a due date and a budget of hours.
where: Support > Projects
---

A project groups the tickets for a job that's bigger than one ticket. It has a manager, a start and due date, a budget of hours and a scope, and it shows how far along the work is.

## The projects list

![The projects list with progress, time against budget and due dates](sd-projects.webp "Projects: progress on tickets and tasks, time logged against the budget, and when each is due")

The tabs are the views you'll want: **Active**, **Mine** (the ones you manage), **Overdue**, **Due soon** (in the next 14 days), **Stalled** (none of its tickets has moved for 14 days), **Over budget** (more hours logged than budgeted), **Ready to close** (every ticket is done), **Completed**, **Archived** and **All**.

Each row shows the project's progress on its tickets and tasks, the time logged against its budget (and how much of it isn't billed yet), when it's due, its manager and the latest activity. Change the manager right in the row.

**Bulk Action** sets the manager or due date, marks projects complete, reopens, archives, restores or deletes them. **Export** in the New Project menu downloads the list as a CSV or PDF.

## Start a project

1. Go to **Support > Projects** (or a client's **Projects**) and click **New Project**.
2. Pick the **Client** and give it a **Name**.
3. Pick a **Template** to raise its tickets for you, in order - see below.
4. Pick the **Manager**, and the **Client contact** who signs it off at the client.
5. Set the **Start** and **Due** dates and the **Budget** in hours.
6. Write the **Scope**: what the project is for and what's included.
7. Click **Create**.

![The New Project window](sd-project-new.webp "New Project: client, template, manager, dates, budget and scope")

### Project templates

A project template is a set of ticket templates in order - say, "Client Onboarding": a site survey, documentation, monitoring, backups and a handover. Picking one raises all its tickets, set up as their templates say. Tick **Assign the template's tickets to the manager** to give them all to the project manager. Your admin makes project templates in [Ticket and project templates](/admin/ticket-templates).

## The project's page

![A project's page with its stat cards, tickets tab, scope and details](sd-project.webp "A project's page: warnings, progress, its tickets, scope and team")

Along the top, a warning shows when something needs a look - past its due date, over budget, stalled. Then four cards: **Tickets done**, **Tasks done**, **Time logged** against the budget (with what's billable and not yet invoiced), and **Due**.

- **New Ticket** raises a ticket in the project.
- **Add tickets** adds **Tickets already raised** - picked from a list or by number - or more tickets **From a project template**.
- **Edit**, **Mark complete**, and **⋮** for its tickets on the ticket list, **Archive** and **Delete**.

The tabs list its **Tickets** (open first), its **Tasks** across every ticket, its **Timeline**, its **Activity** - the replies on its tickets - and **History**. Down the side are the **Scope**, the **Details** (client, contact, manager, dates and budget) and the **Team**, with the hours each person has logged.

### Timeline {#timeline}

The **Timeline** tab shows its booked tickets in time, each as a bar from its booking's start to its end. It runs from the project's start to its due date - or further, when a booking is outside them - by the day, the week or the month, depending on how long that is. A red line marks now, and dashed lines the start and due dates.

![A project's Timeline tab](sd-project-timeline.webp "Timeline: bookings in time, a clash flagged, and the open tickets not booked yet")

- Blue is open, amber is a booking that has passed while the ticket is still open, and grey is resolved or closed.
- Two bookings of the same technician at the same time are outlined in red, with **Same time as** and the other ticket.
- Click a bar to open its ticket. Point at it for when it's booked.
- **Open and not booked** lists its open tickets with no booking yet. **Book** sets one up.

On the Tickets tab, tick tickets and use **Bulk Action** to assign them, set their priority or category, reply to them, resolve them, or **Take off the project**.

## Keep project tickets apart {#apart}

A big project can fill the service desk with tickets that aren't urgent and aren't due on an SLA - its own dates are what count. Switch on **Keep project tickets apart** under **Admin > Settings > Projects** - it's on to start with on a new ITFlow, and off on one updated from an earlier version. While it's on, a ticket that's part of a project:

- is left off the usual views of the [tickets list](/service-desk/tickets#views) - **Open**, **Unassigned**, **Needs reply** and the rest - and has a **Projects** view of its own. It's still under **Mine**, **Mentioned me**, **Closed** and **All**, and the **Project** filter shows a project's tickets as always.
- is left out of the dashboard's unassigned count, the count beside **Tickets** in the menu, and the [Dispatch](/service-desk/dispatch) queue. It still counts in Dispatch's **Workload**.
- has no SLA. Take a ticket out of its project and it gets its SLA back, counted from that moment, so it isn't overdue straight away.
- is booked on the calendar and Dispatch in the project's **Calendar color**, with the project named under it - on the calendar, a dot in the technician's own colour sits beside their name.

![The Project tickets settings](adm-project-tickets.webp "Project tickets: keep them apart from the service desk, and their colour on the calendar")

Switching it off puts everything back as it was, and every open project ticket gets its SLA back, counted from then. A ticket that's already resolved or closed keeps the SLA result it had.

## Finish a project

When the work is done, click **Mark complete**. A project with tickets still open says how many first. A completed project can be reopened from the same place.
