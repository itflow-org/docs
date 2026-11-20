---
title: Lists, quick looks and bulk actions
description: Every list in ITFlow works the same way. Learn it once - searching, filtering, sorting, quick looks, changing things in place and acting on many records at once.
where: Every list
---

Tickets, assets, invoices, credentials, expenses - every list in ITFlow is laid out the same way. This page walks through the parts using a client's assets, but the same buttons are in the same places everywhere.

![A client's assets list, with tabs, filters and sortable columns](gs-list.webp "The parts of a list: the title bar with its New button, tabs with counts, the search box and filters, then the rows")

## Find what you're after

- **Tabs** along the top split the list into the views you use most, each with a count: workstations and servers, open and closed tickets, unpaid and overdue invoices. The count follows your search and filters.
- **Search** - the box on the left - searches just this list. Press <kbd>Enter</kbd> or click the magnifying glass.
- **Filters** beside it narrow the list further: a client, a location, a status, a tag, a date range. Lists with many filters fold the extra ones under **More filters**, which opens with the page while one of them is set.
- A filter that is on is tinted in the [theme](/admin/settings#theme) colour. The **×** at the end of the search box clears the search and every filter at once.
- **Sort** by clicking a column heading. Click it again to reverse the order.
- **Archived** - the box button at the right of the filters - switches to the archived records. Click it again to go back.

### Everything archived lately {#archived}

**Tools > Archived** in the menu lists what was archived lately, every kind together - clients, contacts, locations, vendors, assets, credentials, documents, files, domains, certificates, networks, racks, services, licenses, projects and products - newest first, with who archived each one. It's the place to find something archived by mistake.

![The Archived page](gs-archived.webp "Archived: everything archived in the last 30 days, with who archived it and Restore")

- It shows the last 30 days to start with - pick the last 7 or 90 days, the last year or **Any time** instead. Narrow it to one kind or one client, or search by name.
- **Restore** brings one back. Tick several and use **Bulk Action** > **Restore** to bring them all back at once.
- Click a name to open it, or its list with archived ones showing.

It only lists the kinds of record you can see, for the clients you can reach, and offers **Restore** where you can edit them.

At the foot of the list you can change how many rows show on a page, from 5 to 500, and move between pages. Your choice is remembered for every list. You can also set it in [Your account](/getting-started/account).

When a search or filter leaves nothing, the list says so, with **Clear filters** to go back to the whole list. A tab that only ever shows trouble - Overdue, Expiring soon - shows a tick when it's empty, because nothing there is good news.

## Add something new

The blue button at the top right of the list adds a new record: **New Asset**, **New Ticket**, **New Invoice**. The small arrow beside it opens more choices, such as **Import** and **Export**.

- **Import** takes a CSV spreadsheet, and shows you what each row will do before anything goes in. See [Importing from a spreadsheet](/getting-started/importing).
- **Export** downloads the list as a CSV spreadsheet or a PDF. Its window opens with the search and filters you have on screen, and you can change them there. The **Columns** tab picks what goes in the file. Some columns start unticked - **Client** is one, on contacts, assets, tickets and most other lists - so tick it when you export across all clients and want to see whose each row is.

## Quick looks

A **quick look** is a window with a record's essentials, so you can check something without leaving the page you're on. It has buttons for what you're most likely to do next, and, where the record has one, a button to open its full page.

Records that don't need a page of their own - a login, a domain, an expense, a payment - open in a quick look when you click them in their list. Records with a full page, such as assets and contacts, open that page from their list.

![The quick look for a firewall login, with its username, password, what it's for and buttons to share, change the password or edit it](gs-quicklook.webp "A quick look: the essentials in a window, with what to do next along the bottom")

Quick looks also open from most places a record is mentioned - a ticket's asset, a contact's licenses, a vendor's expenses - so you can check something and carry on with what you were doing.

### A client at a glance {#client-card}

Rest the pointer on a client's name - on the tickets, invoices and other lists, on a ticket, or anywhere it links to the client - and a card shows their primary contact with their phone and email, their main site's phone and address, and how many open tickets they have. Phone numbers and emails in the card can be clicked, and the card stays while you move onto it.

![A client's card under its name on the tickets list](gs-client-card.webp "A client at a glance: their primary contact, their main site and their open tickets")

## Change it where you see it

Many values can be changed right where they are shown, without opening an edit form. Click the value, pick a new one, and it saves straight away:

- a ticket's status, priority, assigned technician and whether it's billable
- a project's manager and a recurring ticket's technician
- an asset's status, location and assigned contact, and a contact's location

**Cancel**, at the top of the list, closes it without changing anything - as <kbd>Esc</kbd> does, or a click anywhere else.

![Clicking a ticket's priority in the tickets list opens a picker with Low, Medium, High and Urgent](gs-quick-pick.webp "Click a value to change it in place")

## Copy buttons

Point at an IP address, MAC address, serial number, email address, phone number, username or password and a small copy button appears beside it. Click it to copy the value.

## Tags

Tags look the same on every list and page: a coloured label with an icon. The **+** at the end of a record's tags opens a list of tags to tick or untick. A list shows a row's tags only when it has some. To tag an untagged one, click **Tags** in its **⋮** menu - the tags you tick show on the row straight away. Cards on the tickets board and the Files grid have **Tags** in their **⋮** menu too. To tag several at once, tick them and use **Tags** in **Bulk Action**.

![Tagging a contact from its row's menu](gs-row-tags.webp "Tags in a row's ⋮ menu: the tag ticked shows under the contact's name straight away")

Tags are a quick way to mark things - VIP clients, devices on monitoring, logins to rotate - and to find them again with the Tags filter or search.

Admins can type a new tag's name straight into the tag list to make it. See [Categories and tags](/admin/categories-and-tags).

## Bulk actions

To do the same thing to several records at once:

1. Tick the box at the start of each row. The box in the column heading ticks every row on the page. To tick a run of rows, tick the first, then hold <kbd>Shift</kbd> and tick the last - every row between them is ticked too. It unticks a run the same way.
2. Click **Bulk Action** at the top of the list. It shows how many rows are ticked.
3. Pick what to do. Some actions ask for more first - which contact to assign, which status to set - in a window.

![The Bulk Action menu on the assets list with three assets ticked](gs-bulk.webp "Bulk Action shows how many rows are ticked and what you can do to them")

What's in the Bulk Action menu depends on the list and on your role: assigning, tagging, setting a status, archiving and so on. A bulk action only changes records you're allowed to change.

## Undo {#undo}

Archiving doesn't ask "Are you sure?" first. Instead, the message that says it's done has **Undo**, which puts it all back as it was - and so does the message after a move or a change to several records at once.

![The message after archiving an asset, with Undo](gs-undo.webp "Asset archived - Undo puts it back")

- **Archiving** - one record or several, of every kind on [Archived](#archived). Undo brings back what archiving took with it too: a contact's roles, a document's links, a client's recurring invoices. Archiving a client still asks first - and has no Undo if it withdrew a contract out for signing, as that can't be put back.
- **Moves** - files, documents and folders moved to another folder, by dragging or with **Move**, and kit dragged to another place on a [rack](/documentation/racks#move).
- **Bulk changes** that set a field: a ticket's priority, category or project; an asset's location, physical location, contact or status; a contact's location, department, phone number or roles; a client's industry or referral; a project's manager or due date; an invoice's or product's category; and an IP address's type.

The message stays up for ten seconds, and for as long as the pointer is on it. Only the x at its right closes it - a click on the message itself does nothing, so one that just misses **Undo** doesn't lose it. Undo works once, and only for you. Anything changed again in the meantime - by you or anyone else - is left as it is, and the message after Undo says how many were.

## Record pages

Most records also have a full page of their own. They share one layout:

- the actions along the top - edit, share, new ticket and the rest
- the key details in cards
- everything related - tickets, files, licenses, history - in tabs with counts. Most pages remember the last tab you had open.

## Forms

Forms have an icon in front of every field. Long forms are split into tabs; if you save with a required field empty on another tab, ITFlow takes you to it.

A field with a list of choices opens it under the field, with a search box when the list is long. **Cancel** at the top closes it without changing the field, and **Done** closes one where you tick several. A click anywhere else closes it too, a reply or other text box included.

Long lists of clients, contacts, vendors, categories, locations, assets, technicians, projects, accounts and products start with **Recent** - the last five you picked in a field like it, anywhere in ITFlow - above **All**. Typing searches everything as usual. Recent picks are kept in your browser.

![A client picker with Recent above All](gs-picker-recent.webp "A client picker: the clients you picked lately come first")

ITFlow asks before it deletes or turns off anything, and before you leave a page with a reply or note you haven't saved. A window you've typed in asks too before it closes - from a click outside it, <kbd>Esc</kbd>, its **×** or **Cancel** - so nothing you typed is lost by accident. Saving never asks.
