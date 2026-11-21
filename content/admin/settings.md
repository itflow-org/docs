---
title: Settings
description: Where ITFlow is set up for everyone - your company details and offices, language and currency, theme, defaults, which parts of ITFlow are in use, and custom links.
where: Admin > Settings
access: Admins
---

> [!ACCESS]
> Everything under **Admin** is for admins - agents whose role has the **Admin** switch on. Your own preferences, such as dark mode and your signature, are under your name instead - see [Your account](/getting-started/account).

**Admin > Settings** shows every settings page at a glance, grouped into **Your company**, **Work**, **Email and notifications**, **Sign-in and access** and **System**, each with how it's set now. Anything that needs looking at - such as card payments still in test mode - is at the top.

![The settings overview](adm-settings.webp "Settings: every settings page with how it's set now, and anything that needs a look at the top")

Don't know where something lives? Type in **Find a setting** - "late fee", "logo", "two-step", "timezone" - and pick it to go straight there.

Each settings page saves on its own. **Undo changes** puts back what was there before you started.

## Your company

### Company details

Your company as it appears on invoices, quotes, statements, emails and the client portal: its **Company name** and **Tax ID**, address, **Phone** (with its country code), **Email**, **Website** and **Logo**.

![Company details](adm-company.webp "Company details: your name, address, contact details and logo, as clients see them")

Click the logo box to add or change it - a PNG or JPG. Drag the corners and edges in to just the logo, or click **Trim the Edges** to cut away the empty space round it. A wide logo prints best, and a PNG keeps a see-through background. See [Change a picture](/getting-started/account#picture).

**Your own client record** links your company to a client in ITFlow, so your own internal tickets, assets and documentation have a home.

### Offices {#offices}

If you work from more than one place, list the others under **Offices** on the Company details page. The **Main office** is the address and phone above.

1. Click **Add an office**.
2. Give it a **Name**, and its address, **Phone** and **Email**. Leave the phone empty to show the main office's, and the email empty to show the address ticket emails come from.
3. In **Who works there**, pick the agents who work from it. Picking someone moves them here from wherever they were.
4. Click **Create**.

![The Offices section](adm-offices.webp "Offices: the main office and the others, with who works from each")

Each agent works from one office - anyone not put in another works from the main one. You can also pick someone's **Office** when you add or edit them in [Users](/admin/users).

- **Trips** - a new trip starts **From** the driver's office (see [Trips](/billing/trips)).
- **Ticket emails** - emails about a ticket show the address, phone and email of the office of the agent on it - the one it's assigned to, or the one sending it - at the bottom.

Invoices, quotes and contracts always show the main office. To change an office, click **Edit**; **Remove** puts those who worked there back in the main office.

### Localization

The **Language** dates and numbers are written in, the **Currency** you bill in, and the **Timezone** ITFlow keeps time in. The page shows how money and the time now will look as you pick them.

### Theme

The colour of the top bar, links, buttons and highlights, and the icon on the browser tab - ITFlow's own, or your own.

![Theme](adm-theme.webp "Theme: the colour ITFlow is shown in, and the browser tab's icon")

## Defaults

What forms start with - each can still be changed on the form:

- **Start page** - the page ITFlow opens on after signing in, and the **Calendar** new events go on
- **Rates and terms** - the **Net terms**, **Hourly rate** and **After-hours rate** a client is billed on when no [contract](/billing/contracts#in-force) in force sets them. A client has none of its own. The after-hours rate is for tickets opened outside the business days and hours in Admin > SLAs; leave it empty and that time bills at the hourly rate. The SLAs are in [Admin > SLAs](/admin/tickets#slas).
- **Accounts** - the account **Payments go into**, the one **Expenses come out of**, the usual payment methods, and where transfers start from and go to

![Defaults](adm-defaults.webp "Defaults: where ITFlow opens, the rates and terms a client is billed on without a contract, and the usual accounts")

## Modules

Switch off the parts of ITFlow you don't use and they're hidden from everyone - from the menus, the dashboard, search, the reports and the API. Their pages and windows say they're switched off. Nothing is deleted: switch a module back on and everything is still there.

- **IT documentation**, **Ticketing**, **Invoicing and accounting**, **Calendar**, **Knowledge Base** and **Client portal** stand on their own. Switching off **Client portal** also signs out every contact signed in to it.
- **Dispatch** comes with **Ticketing**, and **Bookkeeping**, **Purchasing** and **Trips** come with **Invoicing and accounting**. Each is listed under the module it comes with, and is off while that module is - it fades when you switch that one off.

Everything starts on except **Purchasing**, which is off until you switch it on.

What each one takes away:

- **Dispatch** - the [Dispatch](/service-desk/dispatch) board. Tickets are still booked from the ticket, and show on the calendar.
- **Bookkeeping** - [Accounts](/finance/accounts), Transactions, Transfers, [Reconcile](/finance/reconciling) and [Importing statements](/finance/importing-statements). Switch it off when your books are kept somewhere else: nobody picks an account any more. Payments and income go into the account set as **Payments go into** in [Defaults](#defaults), and expenses come out of the one set as **Expenses come out of** - or the first account, when there's no default. An expense is paid by **The business** or **Paid personally**.
- **Purchasing** - To Order, [Purchase orders](/billing/purchase-orders) and Receiving.
- **Trips** - [Trips and mileage](/billing/trips), with the **Mileage** report and the trips in the [Tax package](/finance/tax-package).
- **Calendar** - the [Calendar](/service-desk/calendar), its events and the calendar feeds: a calendar subscribed to a feed stops getting it. Tickets are still booked, and booked work shows on [Dispatch](/service-desk/dispatch) and the dashboard.
- **Knowledge Base** - the [Knowledge Base](/service-desk/knowledge-base) and its articles.

**White-label key** takes "Powered by ITFlow" off the client portal. Left empty, it shows.

![Modules](adm-modules.webp "Modules: the parts of ITFlow in use, with the parts that come with each under it")

## Custom links

**Admin > Custom Links** adds your own links to ITFlow's menus - your RMM, your team's wiki, a distributor's portal. There's a tab for each menu a link can show in, with how many it holds, plus **All menus** and **Archived**. Each link shows its icon, what it's for, where it shows and where it goes. A link whose address can't work is flagged.

![Custom links](adm-custom-links.webp "Custom links: each link, the menu it shows in and where it goes")

Click **New Link**, or **Edit** on a link's menu:

![The window for a custom link](adm-custom-link-form.webp "A link: how it will look in its menu, where it goes and its icon")

- **Looks like** shows the link in its menu as it will be.
- **Name**, and **Goes to** - a web address, a page of ITFlow such as `/agent/unbilled_time.php`, `mailto:`, `tel:`, or a remote tool such as `rdp:` or `ssh:`. A `javascript:` or `data:` address isn't allowed.
- **Open it in a new tab** switches itself on for another site and off for a page of ITFlow, until you change it.
- **Shows in** - the **Agent menu** (under **Tools**), the **Top bar** (as an icon, with its name when pointed at), the **Client portal**, the **Admin menu** (under **Links**) or the **Reports menu**.
- **Description** - shown when someone points at the link.
- **Icon** - search the icons, or type any Font Awesome icon's name.

On a menu's tab, drag the links into the order the menu shows them in, or use **Move Up** and **Move Down**. A new link goes at the end of its menu. **Copy** makes the same link again, to put it in a second menu too. **Archive** hides a link without losing it, **Restore** brings it back, and **Open** tries it.

## Numbering

Tickets, projects, quotes, invoices and recurring invoices each have a **Prefix** and a **Next number**, on their own settings pages. Each page shows what the next one will be called, and the last one made, so you don't reuse a number by mistake.

**Admin > Settings > Projects** also has **Project tickets** - see [Keep project tickets apart](/service-desk/projects#apart).

## Telemetry

**Send the ITFlow project a nightly report** shares how your install is used - how many of each thing, and which features are switched on - to help the project decide what to work on. It holds no names of clients or contacts, no email addresses and nothing anyone wrote, and the page shows exactly what goes.
