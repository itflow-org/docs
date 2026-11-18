---
title: Calendar
description: Your team's schedule - booked tickets, events, project dates, service reviews and renewals - and a link to see it in your own phone or Outlook calendar.
where: Calendar
---

The **Calendar** shows what's booked: tickets scheduled for a visit or a call, events such as meetings and maintenance windows, and dates from the rest of ITFlow. Each client also has its own **Calendar** in its menu.

![The calendar in week view, with events, scheduled tickets and service reviews](sd-calendar-week.webp "The calendar: your own calendars on the left, dates from ITFlow below them, open tickets waiting to be booked, and the ones left behind")

## Find your way around

- **Month**, **Week**, **7 days**, **Day** and **List** at the top right switch the view. **7 days** shows seven days from any day, and its arrows move a day at a time - handy for dragging a booking from Friday to Monday without leaving the view. The arrows move back and forward, and **Today** brings you back.
- **Whose** narrows the calendar to one technician, or shows **Everyone**. The first time you open the calendar it shows your own.
- **Calendars** lists your team's calendars - Default, Internal, Maintenance Windows, Onsite Visits and any others you add with the **+**. Tick or untick one to show or hide it.
- **From ITFlow** shows or hides **Scheduled tickets**, **Projects** (start and due dates), **Service reviews**, **Recurring tickets** (when they'll next run), **Renewals** (domains, certificates, licenses and warranties), **Invoices due** and **Holidays** (the [closure days](/admin/tickets#closure-days) in **Admin > SLA**).

What you show - the calendars, the dates from ITFlow, **Whose** and the view - is kept to your account, so the calendar opens the same way on your computer and your phone.

Click anything on the calendar to open its quick look. Drag a ticket or event to another time to reschedule it. A booked ticket shows for as long as it was booked - drag its bottom edge to make it longer or shorter, and ITFlow asks before it emails the new time.

## Each technician's colour {#colours}

Every technician has a colour, and their booked tickets and the events assigned to them are drawn in it, so you can see whose day is whose at a glance. In the **Week**, **7 days**, **Day** and **List** views, their first name sits beside the time; hover over anything to see who it's for.

Everyone starts with a colour of their own. To pick yours, go to **Account > Preferences** and choose a **Calendar color** (see [Your account](/getting-started/account#preferences)); an admin can pick anyone's from **Edit** in **Admin > Users**. A ticket nobody is assigned to stays in the **Scheduled tickets** colour.

## Book an open ticket

**To schedule**, under the calendars, lists open tickets that have no time booked - the technician in **Whose**, or, with **Everyone**, everyone's, with who has each. Drag one onto the calendar to book it for that time. You can also book a ticket from the ticket itself - see [Working a ticket](/service-desk/working-a-ticket#book-a-visit-or-a-call). When you book from the ticket, the window shows the assigned technician's day, so you can see when they're free.

## Left behind {#left-behind}

**Left behind**, under the calendar, lists open tickets that were booked on a day that has gone - the work wasn't done, and nobody moved it on. The longest left come first, with how many days ago each was booked, and the old booking has a dashed red outline on the calendar.

Drag one onto the calendar to book it again, for as long as it was booked before, or click it for its quick look. Like **To schedule**, it follows **Whose**. When nothing is left behind, the list folds away to its title.

## Add an event

1. Click **New event**, or click (or drag across) a time on the calendar.
2. Give it a **Title**, and pick who it's **Assigned to** - the technicians it's for. It goes on their calendar, in their colour. With more than one calendar, also pick the **Calendar** it's kept on.
3. Under **When**, set when it **Starts** and **Ends**, or switch on **All day**. Under **Repeats**, pick how often it repeats, if it does - every so many days, weeks, months or years, with an end date and dates to skip. A monthly or yearly one can repeat on a weekday rather than the same date: **Repeats on** offers what its start day is, such as **On the third Wednesday** or **On the last Friday**.
4. Pick the **Client**, if it's for one, and the **Location** - a client site, a room, an address, or a Teams or Zoom link.
5. Under **Invite**, add the client's contacts, and anyone else by email.
6. Add **Notes**: what it's for, what to bring, who to ask for.
7. Switch on **Email the invitation to the people on it** to send them a calendar invite their Outlook, Google or phone calendar adds.
8. Click **Add event**.

![The New Event window](sd-event-new.webp "New Event: who it's assigned to, when, where, who else is invited, and whether to send them an invitation")

An event added while **Whose** shows one technician starts assigned to them, and shows on their calendar rather than yours.

When you change or cancel an event with an invitation, the people on it get an update or a cancellation, and their calendar follows. An event's quick look changes who it's **Assigned to** without opening **Edit** - a technician taken off who had the invitation gets the cancellation, and one added gets the invitation when the others have it. The quick look can also download the event as a calendar file, or send the invitation again.

## See your schedule on your phone

Every technician has a private link to subscribe to from their phone, Outlook, Google Calendar, Apple Calendar, Nextcloud or Thunderbird. It stays up to date as work is booked.

1. On the calendar, click **Set it up** (or **My calendar link** once you have one) under the calendars.
2. Under **What it shows**, pick **Just mine** or **The whole team**, and which of **Scheduled tickets**, **Events** and **Projects** to include.
3. Switch on **Busy only** to show just the times, with no titles, clients or addresses - for a calendar other people can see.
4. Click **Make my link**, copy it, and follow the setup help for your calendar app.

![The My calendar link window](sd-calendar-feed.webp "Your calendar link: just yours or the whole team's, and how much it shows")

> [!WARNING]
> Anyone with the link can read what it shows, so keep it to yourself. If it gets out, click **Make a new link** in the same window - the old one stops working - or **Stop the link** altogether. It also stops working when your account is disabled, and only shows what your role and client access let you see.

A calendar can be shared the same way: **Share** in its **⋮** menu makes a subscription link for that calendar alone.
