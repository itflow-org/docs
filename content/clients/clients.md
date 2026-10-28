---
title: Clients
description: Add a client, find one, and keep their details up to date. Everything else in ITFlow - tickets, documentation, invoices - hangs off a client.
where: Clients
---

A client is a company you look after. Its contacts, locations, devices, logins, tickets and invoices all sit under it. The **Clients** list shows every active client, with their open tickets, what they owe and what they bring in each month.

![The clients list with tags, primary contacts, open tickets, balances and recurring revenue](cl-clients.webp "The clients list: who they are, who to call, open tickets, what they owe and what they pay each month")

## The clients list

Each row shows:

- the client's initials, name and industry, with their **tags** - click the **+** to add or remove one
- their **primary contact**, with phone and email
- their primary **location**
- their open **tickets**
- their **balance** - what they owe you, with how much of it is overdue
- **recurring** - what their recurring invoices bring in a month, and the hourly rate their [contract](/billing/contracts#in-force) sets

Click anywhere in the client's name to open it. The **⋮** at the end of the row has **Edit** and **New Ticket**.

The funnel button beside the search box opens the filters: **Tags**, **Industry**, **Referral** and when the client was **Created**.

### Leads

A lead is a company that isn't a client yet - someone you're quoting for. The title bar shows how many clients and leads you have: click **Leads** to switch to them, and back. You can send a lead a quote and keep notes on them like any client. When they sign up, edit them and untick **Is Lead**.

## Add a client

1. Go to **Clients** and click **New Client**.
2. On **Details**, type the client's **Name**. The rest is optional:
   - **Shortened Name** - up to 6 letters, shown where space is tight. Without one, ITFlow uses the initials.
   - **Industry**, **Referral** (where they came from), **Website** and **Tags**.
   - Tick **Is Lead**, beside the name, if they aren't a client yet.
3. On **Location**, add their main office's address and phone. It becomes their primary location.
4. On **Contact**, add the main person you deal with. They become the primary contact.
5. On **Billing**, set their tax and reminders (see below).
6. Click **Create Client**.

![The New Client window on its Details tab](cl-new-client.webp "New Client: Details, Location, Contact, Billing and Notes")

You can add more locations and contacts afterwards. See [Locations](/clients/locations) and [Contacts](/clients/contacts).

### Billing details

![The Billing tab of the New Client window](cl-new-client-billing.webp "Billing: where the rates, terms and SLAs come from, tax and reminders")

A client has no hourly rate, payment terms or SLAs of its own - they come from its [contract](/billing/contracts#in-force), and your defaults cover the rest, from [Admin > Settings > Defaults](/admin/settings) and [Admin > SLAs](/admin/tickets#slas). The Billing tab says what the client is billed on and where it comes from, with a link to its contracts. A new client is billed on your defaults until it has a contract.

- **Tax ID** - the client's own tax number, if they need it on invoices.
- **Payment reminders and statements** - switch off to leave this client out of automatic payment reminders and monthly statements. You can still send them by hand.
- **Tax Rate** - the tax their invoice lines start with, when it isn't your default.
- **Tax exempt** - for a client that doesn't pay tax, such as a charity or school, with their **Exemption Certificate** number and when it **Expires**. Their new lines start untaxed, and their invoices say they are exempt.

## Change a client's details

Open the client and click **⋮** in its header, then **Edit Client**. The Edit window has **Details**, **Billing** and **Notes**.

The same **⋮** menu has:

- **New Ticket** and **New Project** for this client
- **Export Data** - a documentation PDF or a full export. See [Exporting a client's data](/clients/export).
- **Client Review** - a report of the client's quarter, made to print for a business review. See [Reports](/finance/reports).
- **Archive Client**

![The client header with its menu open](cl-client-menu.webp "The menu in a client's header")

## Do something for several clients

Tick the clients in the list and click **Action**. You can:

- **Open Tickets** - raise the same ticket for each of them, such as a quarterly check. Each ticket can go to the client's primary contact, and can start from a ticket template.
- **Send Email** - email them, with your logo and details around what you write.
- **Tags**, **Set Industry** and **Set Referral**
- **Archive**

## Archive a client

When you stop working with a client, archive them rather than deleting them. An archived client drops out of the lists and menus, but everything you had for them - tickets, invoices, documentation - is kept, and their contacts can no longer sign in to the client portal.

Open the client, click **⋮ > Archive Client** and confirm. To see archived clients, click **Archived** on the clients list. **Restore** is in each one's **⋮** menu, and in the header menu of an archived client.
