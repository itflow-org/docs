---
title: Recurring tickets
description: Tickets that raise themselves on a schedule - monthly maintenance, backup checks, quarterly reviews - so routine work is never forgotten.
where: Support > Recurring Tickets
---

A recurring ticket is a ticket ITFlow raises for you on a schedule: every week, every month, every quarter. Use them for routine work you never want to forget - patching, backup restore tests, checking a client's firewall, the quarterly business review.

![The recurring tickets list](sd-recurring.webp "Recurring tickets: what each raises, how often, when it next runs, its last ticket and who it goes to")

The list shows each one's client, **How often**, **Next run**, **Last ticket** and **Agent**. The tabs show **All**, **Due this week**, **Missed** (runs that didn't happen), **Paused** and **Unassigned**.

## Set one up

1. Go to **Support > Recurring Tickets** (or a client's **Recurring Tickets**) and click **New Recurring Ticket**.
2. On **Details**, pick the **Client** and **Contact**, and a **Template** if one fits. Type the **Subject** and details, and set the **Priority**, **Category**, who to **Assign to**, and whether **The tickets it raises are billable**.
3. On **Schedule**, pick the **Frequency** - every three days, weekly, biweekly, monthly, quarterly, twice a year or yearly - and the **First run**. For a monthly to yearly one, **Repeats on** picks the same date or the same weekday each time - see [Repeat on a weekday](#weekday). The schedule is written out in plain words, with when it will next run. To book the work, and to raise the tickets ahead of the day, see [Book the work and make it ahead](#ahead).
4. On **Related**, link the **Asset** it's for. On **Tasks**, add the steps.
5. Click **Create**.

![The New Recurring Ticket window](sd-recurring-new.webp "New Recurring Ticket: Details, Schedule, Related and Tasks")

The nightly run raises the ticket on the day, then again each time it comes round. Monthly ones keep to the day they started on - the 31st runs on the last day of a shorter month - unless they repeat on a weekday.

> [!TIP]
> Placeholders such as `[Month]` and `[Quarter]` are filled in each time it raises a ticket, so "Monthly maintenance - [Month]" becomes "Monthly maintenance - November 2026". A template's fill-ins are answered once, here, for every ticket it raises.

## Repeat on a weekday {#weekday}

Some work follows the week, not the date: patch night on the third Wednesday, the month-end check on the last Friday. A monthly, quarterly, twice-yearly or yearly recurring ticket can repeat that way.

1. On **Schedule**, pick the **Frequency** and set the **First run** to a day it should fall on - the third Wednesday of the month, say.
2. **Repeats on** appears under it, with what that day is: **On the 16th**, and **On the third Wednesday**. A day in the last week of the month also offers **On the last Wednesday**.
3. Pick the weekday. A yearly one stays in its month - **On the third Wednesday of December**.

![Repeats on, on the Schedule tab](sd-recurring-schedule.webp "Repeats on: the same date each time, or the same weekday of the month")

The list shows it under **How often** - "on the third Wednesday". When you move its next run, from **Edit** or **Set Next Run**, it keeps to the same kind of weekday: move a third-Wednesday one to the second Wednesday and it runs on second Wednesdays from then on. A last-Friday one stays on the last Friday whenever the new day allows it.

## Book the work and make it ahead {#ahead}

Also on **Schedule**:

- **Book the work for** - a time, how long it takes, and **Remote** or **Onsite**. Each ticket it raises is booked for its run day at that time, for that long, as booking it on the ticket would: the technician, and the contact and watchers when client emails are on, get the time with a calendar invite, and it shows on the [calendar](/service-desk/calendar). Leave the time empty to book nothing.
- **Make it ahead** - raise each ticket so many days before its run day, so it's on the board and on everyone's calendar in good time. The run day stays the day the work is for.
- **Days before the 1st of its month** makes every run in a month on the same day - with 3, all of December's visits are raised on November 28, each booked for its own day. It's for monthly, quarterly, twice-yearly and yearly ones.

Days ahead stop short of the next run - under a week for a weekly one, for example. The window says when the next one will be made, and the list shows the time and the days ahead under **How often**.

## Run, pause and change

From a recurring ticket's **⋮** menu, or **Bulk Action** for several:

- **Raise Now** - raise the next ticket straight away, without waiting for its day.
- **Pause** and **Resume** - stop it for a while, such as while a client is between contracts.
- **Assign**, **Set Priority**, **Set Category**, **Set Billing** and **Set Next Run**.
- **Edit** and **Delete**.

The technician a recurring ticket goes to can be changed right in the list. Each ticket it raises is marked with the recurring arrows in the tickets list.
