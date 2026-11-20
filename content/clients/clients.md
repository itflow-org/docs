---
title: Clients
description: Add a client, find one, and keep their details up to date. Everything else in ITFlow - tickets, documentation, invoices - hangs off a client.
where: Clients
---

A client is a company you look after. Its contacts, locations, devices, logins, tickets and invoices all sit under it. The **Clients** list shows every active client, with their open tickets, what they owe and what they bring in each month.

![The clients list with tags, primary contacts, open tickets, contracts, balances and recurring revenue](cl-clients.webp "The clients list: who they are, who to call, open tickets, their contract, what they owe and what they pay each month")

## The clients list

Each row shows:

- the client's initials, name and industry, with their **tags** - click the **+** to add or remove one
- their **primary contact**, with phone and email
- their primary **location**
- their open **tickets**
- their **contract** - the one in force, with when it renews or ends, and **+1 more** when others are in force too. **None** means they're billed on your defaults: it shows the next contract to start, or a draft, if they have one, or **Start a contract**.
- their **balance** - what they owe you, with how much of it is overdue
- **recurring** - what their recurring invoices bring in a month, and the hourly rate they're billed at - their [contract](/billing/contracts#in-force)'s, or your default rate, marked **(default)**

Click anywhere in the client's name to open it. The **⋮** at the end of the row has **Edit** and **New Ticket**.

The funnel button beside the search box opens the filters: **Tags**, **Industry**, **Referral**, **Contract** - one in force, none in force, or one started from a particular template - and when the client was **Created**. Click **Contract** at the top of the column to sort by it.

### Leads

A lead is a company that isn't a client yet - someone you're quoting for. The title bar shows how many clients and leads you have: click **Leads** to switch to them, and back. You can send a lead a quote and keep notes on them like any client. When they sign up, edit them and untick **Is Lead** - or [onboard them](/clients/onboarding), which makes them a client and takes you through the rest.

Leads stay out of the way of the clients you work for. They aren't offered when you pick a client for something new - an asset, a contact, an invoice, a trip and so on - or in the client switcher and the client filters. They are offered when you pick a client for a quote, marked **Lead**, after your clients. Global search still finds a lead by name, marked **Lead**, after any clients that match. To add something to a lead, start from the lead's own page: whatever you add there is for it.

## Add a client

1. Go to **Clients** and click **New Client**.
2. On **Details**, type the client's **Name**. The rest is optional:
   - **Shortened Name** - up to 6 letters, shown where space is tight. Without one, ITFlow uses the initials.
   - **Industry**, **Referral** (where they came from), **Website** and **Tags**.
   - Tick **Is Lead**, beside the name, if they aren't a client yet.
3. On **Location**, add their main office's address and phone. It becomes their primary location.
4. On **Contact**, add the main person you deal with. They become the primary contact.
5. On **Billing**, pick a **Contract** template if you like, and set their tax and reminders (see below).
6. Click **Create Client**.

![The New Client window on its Details tab](cl-new-client.webp "New Client: Details, Location, Contact, Billing and Notes")

You can add more locations and contacts afterwards. See [Locations](/clients/locations) and [Contacts](/clients/contacts).

Taking on a client properly? **Onboard a client**, under the arrow beside **New Client**, walks you through their sites, people, agreement, billing, domains, vendors, licenses and onboarding project a step at a time. See [Onboarding a client](/clients/onboarding).

### Import clients {#import}

To bring in many clients at once, use **Import**, under the arrow beside **New Client**, with a CSV spreadsheet. The window shows what each row will do before anything goes in - see [Importing from a spreadsheet](/getting-started/importing). Only **Client Name** is needed, and a client already in ITFlow is found by its name. **Template** has every heading:

- **The client** - Client Name, Industry, Referral, Website, Lead, Abbreviation, Currency, Tax ID, Tags and Notes.
- **Billing** - Tax Rate (one of your tax rates, by name), Tax Exempt, Exemption Certificate and Exemption Expires, and an Hourly Rate and Payment Terms in days. For a new client, a rate or payment terms other than your defaults gives it a **Standard terms** [contract](/billing/contracts) carrying them. Updating a client leaves its rate and terms alone - change them on its contract.
- **Its primary location** - Primary Location Name, Location Phone, Location Address, City, State, Postal Code and Country.
- **Its primary contact** - Primary Contact Name, Title, Contact Phone, Extension, Contact Mobile and Contact Email.

Updating a client changes its primary location and contact, or adds them when it has none. A file exported from the clients list imports as it is.

### Billing details

![The Billing tab of the New Client window](cl-new-client-billing.webp "Billing: where the rates, terms and SLAs come from, tax and reminders")

A client has no hourly rate, payment terms or SLAs of its own - they come from its [contract](/billing/contracts#in-force), and your defaults cover the rest, from [Admin > Settings > Defaults](/admin/settings) and [Admin > SLAs](/admin/tickets#slas). The Billing tab says what the client is billed on and where it comes from, with a link to its contracts. A new client is billed on your defaults until it has a contract.

- **Contract** - a [contract template](/admin/contract-templates) to start the client's contract from, and the day it's in force **From** - today, to start with. The contract is made active when the client is created, with the template's type, term, rates, net terms, SLAs and terms, the primary contact, and you to look after it. Leave it on **None** to bill on your defaults. You need **Sales** at **Modify** to see it.

- **Tax ID** - the client's own tax number, if they need it on invoices.
- **Payment reminders and statements** - switch off to leave this client out of automatic payment reminders and monthly statements. You can still send them by hand.
- **Tax Rate** - the tax their invoice lines start with, when it isn't your default.
- **Tax exempt** - for a client that doesn't pay tax, such as a charity or school, with their **Exemption Certificate** number and when it **Expires**. Their new lines start untaxed, and their invoices say they are exempt.
- **No card fee** - when clients [pay the card fee](/admin/payment-providers#card-fee), switch this on for a client who shouldn't. Their card payments are just the invoice. It shows while Stripe is set up.

## Change a client's details

Open the client and click **⋮** in its header, then **Edit Client**. The Edit window has **Details**, **Billing** and **Notes**. **New contract** on **Billing** starts another contract from a template, from the day you pick. For what it sets, it comes first, ahead of the contract in force now - end that one from its page if the new one replaces it.

The same **⋮** menu has:

- **New Ticket** and **New Project** for this client
- **Onboard** - take the client on a step at a time, or **Carry on onboarding**. See [Onboarding a client](/clients/onboarding).
- **New Banner** - a note along the top of the client's pages for your team, such as a credit hold, and below it the client's banners to change. See [Banners for your team](/clients/banners).
- **Export Data** - a documentation PDF or a full export. See [Exporting a client's data](/clients/export).
- **Client Review** - a report of the client's quarter, made to print for a business review. See [Reports](/finance/reports).
- **Offboard** - everything that still runs for a client you've stopped working with, in one go. See [Offboard a client](#offboard).
- **Archive Client**
- **Merge into another client** - for the same company added twice. See [Merge duplicate clients](#merge).

![The client header with its menu open](cl-client-menu.webp "The menu in a client's header")

## Do something for several clients

Tick the clients in the list and click **Action**. You can:

- **Open Tickets** - raise the same ticket for each of them, such as a quarterly check. Each ticket can go to the client's primary contact, and can start from a ticket template.
- **Send Email** - email them, with your logo and details around what you write.
- **Tags**, **Set Industry** and **Set Referral**
- **Start Contract** - a contract from a template for each of them, active from the day you pick
- **Archive**

## Archive a client

When you stop working with a client, archive them rather than deleting them. An archived client drops out of the lists and menus, but everything you had for them - tickets, invoices, documentation - is kept, and their contacts can no longer sign in to the client portal - anyone signed in is signed out. Their [contracts](/billing/contracts#renew) are left as they are - not renewed, ended or reminded of overnight - and a contract out for them to sign is withdrawn.

Open the client, click **⋮ > Archive Client** and confirm. To see archived clients, click **Archived** on the clients list. **Restore** is in each one's **⋮** menu, and in the header menu of an archived client.

### Offboard a client {#offboard}

**⋮ > Offboard** does the jobs for a client you've stopped working with in one window, so none gets missed. Each step says how much it will do, and is ticked when there's something to do:

- **Turn off client portal sign-in** - nobody at the client can sign in to the portal any more, and invites still waiting are cancelled.
- **End shared links** - links you've shared with them that still work stop working.
- **Stop recurring invoices** - nothing more is invoiced. Needs a role that can change invoices.
- **Pause recurring tickets** - no more tickets are made for them. Needs a role that can change tickets.
- **Archive the client**, as above.

![The Offboard window with a step for portal sign-in, shared links, recurring invoices, recurring tickets and archiving](cl-offboard.webp "Offboard: each step says what it will do, and is ticked when there's something to do")

Untick any you want to leave, and click **Offboard**. Nothing is deleted, and everything but the ended links can be turned back on from where it lives. To keep a copy of everything first, click **Export Data** at the top of the window - see [Exporting a client's data](/clients/export). The window also says how many of their tickets are still open, to resolve or close as you finish the work.

## Merge duplicate clients {#merge}

When the same company has been added twice, its tickets, invoices and documentation end up split between the two. Merge them into one:

1. Open the client you want to go - the duplicate - and click **⋮ > Merge into another client**.
2. Pick the client to keep under **Merge into**. The window lists what moves across.
3. Tick **I understand this can't be undone**, and click **Merge**.

![The Merge window with the client to keep picked and what moves across](cl-merge.webp "Merge: pick the client to keep, and see what moves across")

Everything the duplicate had moves to the kept client: contacts, locations, assets, tickets, projects, invoices and their payments, quotes, contracts, expenses and trips, documents, files and folders, logins, domains, certificates, networks, licenses, services, vendors and calendar events, with its tags, shared links, history and audit log. Its files and contact photos move too.

The kept client's details stay as they are - name, billing settings, rates, primary contact and primary location. The duplicate's quick notes are added under the kept client's. Where the two had cards saved with the same card provider, the kept client's stay, and the duplicate's saved cards can't come across - set up autopay again on the kept client if it needs it.

The duplicate is left archived and empty, named "*Name* (merged into *Other*)", so nothing that pointed at it is lost. Delete it once you're happy.

If some of your technicians only see some clients, the window names any whose access differs between the two - someone who could see the duplicate but not the kept client won't see what moved. Check their access in [Users](/admin/users) afterwards.

Merging takes the **Delete** level of access to clients.
