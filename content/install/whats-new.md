---
title: What's new in ITFlow
description: The highlights of every ITFlow release, newest first, and the releases that need a step of their own when you update past them.
---

Every release of ITFlow, newest first, with the changes your team will notice. The full notes for each one - every fix, and the detail for developers - are in the [changelog on GitHub](https://github.com/itflow-org/itflow/blob/master/CHANGELOG.md), and **Admin > Update** shows the notes for each release between yours and the newest. To update, see [Updating ITFlow](/install/updating).

Releases are numbered by year and month, such as 26.12. The releases in between add a third number, so 26.12.2 is the second release after 26.12.

## Releases that need a step of their own {#steps}

Most releases need nothing but the update itself. The ones below need something more. If your update takes you past one of them - from an older version, say - do its step too, in order.

| Release | What to do |
|---|---|
| [26.12](#v26-12) | Send API keys in the `X-API-Key` header instead of in the address. A key in the address still works, but ends up in your web server's logs - once a script sends it in the header, give it a new key. |
| [26.09](#v26-09) | Coming from 26.08 or earlier: update the files as usual, then run the database update [from the command line](/install/updating#command-line) one last time. From then on, **Admin > Update** does both. |
| [26.08](#v26-08) | Take your old ITFlow lines out of the crontab, update the files, run the database update from the command line, then add the one new cron line. Every API key is deleted, as keys now act as a user - make new ones. |
| [25.12](#v25-12) | Install PHP's XML extension (`sudo apt install php-xml`), which documents need. |
| [25.11](#v25-11) | The old cron scripts in `scripts` are gone - use the ones in `cron`. (26.08 later replaces them all with one line.) |
| [25.10](#v25-10) | The agent pages moved from `/user/` to `/agent/`. Update bookmarks and any custom code. |
| [25.09](#v25-09) | Update from the command line. AI settings are reset, so set your AI provider up again, and the `xcustom` folder is now `custom`. |
| [25.06](#v25-06) | Earlier versions of documents are deleted, as versions are now kept a new way. |
| [25.03](#v25-03) | Update from the command line, files and then the database. |
| [25.02](#v25-02) | The cron scripts moved to the `scripts` folder - point your cron lines at them. |
| [25.01](#v25-01) | The client portal moved from `/portal` to `/client`, and guest links to `/guest`, so links in older emails stop working. Sign-in with Microsoft Entra ID needs its redirect address changed to `/client`. |

## 26.12.2 {#v26-12-2}

- **Stronger vault encryption.** Each agent's and API key's copy of the credential vault's key is now sealed with AES-256, under a key worked out from their password with 600,000 rounds. Each copy moves over by itself, at the agent's next sign-in or the key's next API call, and [Backups](/admin/maintenance) lists any still sealed the old way, with a button to retire them.
- **2FA keys are encrypted.** A login's 2FA secret is now encrypted with the vault, like its username and password. See [Credentials](/documentation/credentials).
- **One payment reminder per client.** A client with more than one late invoice gets one reminder listing everything they owe, on the days of their oldest late invoice, instead of an email for each invoice. See [Reminders and statements](/billing/reminders-and-statements).
- **Log settings** are now a Settings tab under **Admin > Logs**. See [Audit logs, sign-ins and app logs](/admin/logs).
- **Managed instances:** problems on an install you manage can open tickets, and each instance's page has a History card - agents, storage, uptime, errors, backups and usage, a day at a time - and an Agents card. See [Managing other ITFlow installs](/admin/managed-instances).
- **Fixes:** a mistyped two-step code no longer signs you in with the vault closed, the pen to edit or remove a racked asset is always shown, and adding several ports at once keeps the space in their names.

## 26.12.1 {#v26-12-1}

- **Phone systems.** FusionPBX calls come into ITFlow: a Calls page on the menu and on each client, the caller's contact and client on your desk phones as they ring, Yealink and Polycom phones added as Phone assets, and screen pops on your own desk phone. See [Phone systems with FusionPBX](/admin/phone-systems) and [Calls](/service-desk/calls).
- **Network platforms.** Your clients' UniFi gateways, switches and access points come in as assets, and their sites' networks and VLANs as the client's networks. Each asset shows the switch port or access point it is on, and a device that goes offline can open a ticket. See [Network platforms with UniFi](/admin/network-platforms).
- **RMM providers:** link a device to the asset it really is, assign an asset to the contact signed in to it, choose the asset types devices come in as, and see a client's devices at a glance on their overview. See [RMM providers](/admin/rmm).
- **Racks:** devices side by side on one row - two small PCs in a 1U bracket, say - in a holder with slots. See [Racks](/documentation/racks).

## 26.12 {#v26-12}

- **RMM providers.** Devices from Tactical RMM come in as assets and stay up to date, with whether each is online on the asset. Alerts can open tickets and resolve them when they clear, and a recurring invoice line can bill per managed device. See [RMM providers](/admin/rmm).
- **Dispatch.** A page that puts each agent's booked work beside the tickets still to give out, to drag onto their day. See [Dispatch](/service-desk/dispatch).
- **Knowledge Base.** How-tos and fixes written once for every client, for your team, your clients or anyone, offered on tickets, in the client portal and on a public help centre. See [Knowledge Base](/service-desk/knowledge-base).
- **Purchasing.** To Order, Purchase Orders - with approval and tracking numbers - and Receiving, under Billing. See [Purchase orders](/billing/purchase-orders).
- **Tickets:** Quick ticket and a timer in the top bar on every page, more than one agent on a ticket, related tickets linked, bookings with a length and an agent, when the work was done on each note, a reply kept as you type it, and Resolve - no response. See [Working a ticket](/service-desk/working-a-ticket).
- **Calendar:** a colour for each agent, events assigned to agents, a 7 days view, Left behind for bookings that were missed, holidays and reminders. Agents who work away from the company can use their own time zone. See [Calendar](/service-desk/calendar).
- **Imports:** one Import window for clients, contacts, locations, credentials, networks, assets, products and more, which can update records already there, so a list can be exported, changed and imported back. See [Importing from a spreadsheet](/getting-started/importing).
- **Microsoft 365 through Graph:** send email and read the support mailbox without SMTP or IMAP. See [Mail](/admin/mail).
- **Backups and cron:** restore a backup from the page, development mode for a test copy, and Cron Watch to email your admins when a job fails or falls behind. See [Backups, cron, updates and starter content](/admin/maintenance).
- **Money:** a cost and a picture on quote lines, [labor costs](/admin/labor-costs) behind Client Profitability, the [Tax package](/finance/tax-package) report, a Geography map, and every report as a PDF.
- **Your own asset types**, [banners](/clients/banners) for your team on a client's pages, and Merge and Offboard for clients. See [Asset types](/admin/asset-types) and [Clients](/clients/clients).
- **Everywhere:** a shorter menu, Undo instead of "Are you sure?" when archiving, shift-click to tick a run of rows, windows that ask before closing on something unsaved, and switches to take out the parts of ITFlow your business doesn't use.
- **API:** invoices, quotes, payments, projects, contracts, files, calendar events and much more. See [Getting started with the API](/api/overview).

Dispatch, Purchasing, much of the calendar and ticket work, quote costs, Cron Watch, development mode and Microsoft 365 through Graph came from Mountaineer IT's build of ITFlow, and they found several of this release's security fixes.

## 26.11.8 {#v26-11-8}

- **Invoice, quote and recurring invoice lines** are added and changed on the page itself - click a line's name, quantity or price to change it - without reloading.
- **Backup and Cron** are rebuilt to answer the question you open them with: is ITFlow backed up, and is cron running? Both keep themselves up to date. See [Backups, cron, updates and starter content](/admin/maintenance).
- **SLAs** are a list like every other, with targets in hours and minutes, and holidays and closure days in one place. See [Tickets, statuses and SLAs](/admin/tickets).
- **Speed:** the dashboard, projects and invoices open much faster on an install with years of history.

## 26.11.7 {#v26-11-7}

- **A fix for a blank dashboard** on some upgraded installs, caused by tables with different text rules (collation). ITFlow now keeps them the same by itself, and **Admin > Debug** can repair them.
- **Speed:** the dashboard and the menu on every page are much quicker on an install with years of history.

## 26.11.5 and 26.11.6 {#v26-11-5}

- **Users:** a Client portal view of everyone who can sign in to the portal, at all your clients. See [Users](/admin/users).
- **Contacts:** the export can include each contact's client.
- **Security fixes,** and pages no longer act up after an update until each person clears their browser's cache.

## 26.11.4 {#v26-11-4}

- **Text messaging** through Skyetel. A text from a contact opens a ticket, and contacts who agree hear about their tickets and visits by text. See [Text messaging with Skyetel](/admin/text-messaging) and [Texts and verification codes](/service-desk/texts).
- **Managed instances:** one ITFlow can now manage others - a client's, a reseller's or your own hosted ones. See [Managing other ITFlow installs](/admin/managed-instances).
- **Clients can pay the card fee** on Stripe, and a lead that pays an invoice in full becomes a client by itself. See [Card payments with Stripe](/admin/payment-providers).
- **Demo mode** for a public demo, and a new install starts with cron switched on. See [Running a public demo](/install/demo).
- **Tickets:** a ticket waiting on an invoice is told when it is paid, and the IT documentation PDF can go out as a secure link.

## 26.11.3 {#v26-11-3}

- **Security fixes.** Changing a password now signs that account out everywhere else, and agents are emailed when MFA is turned on for their account.
- **API keys:** agents are told a week before a key expires.
- **Stripe fees** are recorded as an expense within about 15 minutes of a card payment instead of the next morning.

## 26.11.1 and 26.11.2 {#v26-11-1}

- **Transactions** load faster on books with years of history, and a fix for long decimals on trips.

## 26.11 {#v26-11}

A big release, with almost every page rebuilt. Take a backup before you update.

- **Search:** press <kbd>Ctrl</kbd> <kbd>K</kbd> for results as you type, across every kind of record. See [Searching](/getting-started/search).
- **Quick looks and record pages:** most records open in a quick look without leaving the page, and licenses, locations, vendors, racks and services have pages of their own. See [Lists, quick looks and bulk actions](/getting-started/lists).
- **Dashboard and reports** are rebuilt: what needs attention, your day and the money, with reports grouped and searchable. See [Reports](/finance/reports).
- **Contracts:** every agreement with a client, with its term, renewal, SLAs and prepaid hours, sent to the client to sign. See [Contracts](/billing/contracts), [Prepaid hours](/billing/prepaid-hours) and [Sending a contract to sign](/billing/contract-signing).
- **Billing:** new lists and pages for invoices, quotes and recurring invoices, a new look for the PDFs with a QR code to pay, products with their cost and margin, and taxes made of parts. See [Invoices](/billing/invoices).
- **Tickets:** views such as Mine, Needs reply and Overdue, a redesigned board, @mentions in internal notes, a clear choice between an internal note, a public note and an email reply, and templates that set up the whole ticket. See [The tickets list](/service-desk/tickets).
- **Invites:** invite agents, and people to a client's portal, by email - they set their own password. See [Users](/admin/users) and [Invites and signing up](/portal/invites).
- **Client onboarding:** take a new client on a step at a time, and a Get started guide for a new install. See [Onboarding a client](/clients/onboarding).
- **The client portal** has a new look, with what needs the contact first on its home page. See [What clients see](/portal/overview).
- **AI:** draft a ticket reply, summarise a ticket, reword or translate, and write invoice and quote lines. See [Using AI](/getting-started/ai).
- **Admin:** rebuilt Settings with Find a setting, roles, API keys, audit logs, the mail queue, previews of every email ITFlow sends, and the setup wizard. See [Settings](/admin/settings).

## 26.10 {#v26-10}

- **Recurring invoices** can make a draft for you to check instead of sending it automatically. See [Recurring invoices](/billing/recurring-invoices).
- **Invoices:** a ticket can be taken back off an invoice and returned to Unbilled Time.
- **Fixes:** about one card payment in fifteen was charged a cent short, and copy buttons in pop-up windows work again.

## 26.09.1 to 26.09.3 {#v26-09-1}

- **Invoices:** a partly paid invoice shows what is still owed, and the Unpaid total, Tax Summary and the dashboard count partly paid invoices correctly.
- **Fixes** for IP address fields and the product picker on quotes.

## 26.09 {#v26-09}

- **A new look** throughout, with dark mode carried properly everywhere, and your theme colour on the client portal, guest pages and sign-in.
- **Canned responses** for ticket replies. See [Canned responses](/service-desk/canned-responses).
- **SLA holidays:** the SLA clock pauses on the days you are closed.
- **IP addresses:** document every address in a subnet. See [Networks and IP addresses](/documentation/networks).
- **Invoices and quotes:** Quick Send, Send Email to the contacts you pick, Mark Sent with how it was sent, and refunds through Stripe. See [Taking payments](/billing/payments).
- **Client statements**, sent from the invoice list. See [Reminders and statements](/billing/reminders-and-statements).
- **Your own company** as a client record, and demo data to try ITFlow out on.
- **Updates run through cron** from **Admin > Update**, instead of in your browser.

## 26.08.1 and 26.08.2 {#v26-08-1}

- **Fixes** for the setup wizard, the agent calendar, **Maintenance > Cron** and exports, and pages are faster, as they read only what they use.

## 26.08 {#v26-08}

- **Backups** are encrypted, scheduled by cron, listed on the page and restorable from the command line. See [Backups, cron, updates and starter content](/admin/maintenance).
- **One cron line** runs everything, with a page to see and manage each job.
- **Tickets:** a new tickets list, board and ticket page, SLAs, an Urgent priority, and attachments from inside ITFlow. See [Tickets, statuses and SLAs](/admin/tickets).
- **Calendar:** subscribe from Google Calendar or Nextcloud, all-day and repeating events, and click to add an event.
- **Money:** one Income page, a Transactions page for each account, and exports with filters and columns to pick.
- **API keys** act as a user, with that user's permissions. See [Keys and permissions](/api/permissions).
- **Assets:** several notes per asset, and the dashboard warns about warranties and licenses running out.
- **Security fixes** throughout.

## 26.07 and 26.07.1 {#v26-07}

- **Mail settings** rewritten for Microsoft 365 and Google sign-in (OAuth2). See [Mail](/admin/mail).
- **Security fixes.**

## 26.05 and 26.05.1 {#v26-05}

- **Fixes** for saved cards in the client portal and slow project pages, with password reset links now cleared nightly.
- **Security fixes.**

## 26.04 {#v26-04}

- **Categories** for asset statuses, interface types, note types, software types and rack types, so you can make your own. See [Categories and tags](/admin/categories-and-tags).
- **Licenses** have more license types, such as Perpetual and Site.
- **Networks** can be imported.

## 26.02 and 26.02.1 {#v26-02}

- **Task approvals:** a task can need approval from your team or the client before it is done.
- **Favourites:** star assets and credentials to put them on the client's overview.
- **Faster everywhere,** with queries up to 50% faster and less memory used on the server.
- **Microsoft 365 and Google** mail sign-in (OAuth2) is stable.
- **Packing slips** for invoices, collapsible folders in Files, and time worked shown as 2h 41m.
- **Fixes** for agents who can only see some clients, and a Client Detail Audit report.

## 25.12 and 25.12.1 {#v25-12}

- **Files and documents** are one section, Files.
- **Replies by subject:** an email whose subject matches a recent ticket from the same contact or domain goes on that ticket.
- **One sign-in page** for agents and clients.

## 25.11 and 25.11.1 {#v25-11}

- **Asset tags,** and quick add links in the side menu.
- **Bulk tickets** for a client, a warning about duplicate clients, and 30-day warnings for domains and certificates.
- **Credentials** import and export their 2FA keys, and invoices can be paid from a saved card on the list.
- **The old cron scripts are removed,** and PHP's IMAP extension is no longer needed.

## 25.10 and 25.10.1 {#v25-10}

- **Archiving a user** can hand their open and recurring tickets to someone else.
- **HTML signatures,** and a project can be changed from its ticket.
- **Custom folders** for your own code, which updates leave alone.

## 25.09 to 25.09.2 {#v25-09}

- **Stock:** products and services, with stock levels kept as invoices use them.
- **Card payments** rebuilt, with more than one saved card per client.
- **Dark mode.**
- **First response time** on tickets, with a report.
- **Client portal:** clients can pick an asset when raising a ticket.
- **AI** rebuilt, with a ticket summary in three parts, and Microsoft 365 and Google mail sign-in in beta.

## 25.06 and 25.06.1 {#v25-06}

- **Due dates** on tickets.
- **Invoices and quotes** redesigned, with new PDFs.
- **Recurring payments** charge on the invoice's due date.
- **Document versions** kept a new way - see [the step](#steps).

## 25.05 and 25.05.1 {#v25-05}

- **Full backups,** with your files, and restore from setup.
- **Clients set up autopay** from the portal, and see their balance and expiring domains there.
- **Countries** on clients and locations, with a filter.

## 25.03 to 25.03.6 {#v25-03}

- **Several assets on a ticket,** and replies can be redacted.
- **International phone numbers** and signatures on replies.
- **Documents as PDFs,** and pictures are saved as WebP.

## 25.02 to 25.02.4 {#v25-02}

- **The client overview,** and quick looks at assets, contacts and documents.
- **Board and simple views** for tickets, and drag-and-drop ordering for invoice lines and tasks.
- **Certificate history,** and categories and tags made on the spot.

## 25.01 to 25.01.3 {#v25-01}

- **Saved cards** with Stripe for automatic invoice payments.
- **Asset interfaces** show what they are connected to.
- **Domain history,** and recurring tickets without a contact.
- **A clearer MFA setup.**

## 24.12 {#v24-12}

- **The first numbered release** of ITFlow.
