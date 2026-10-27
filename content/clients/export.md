---
title: Exporting a client's data
description: Hand a client their documentation as a printable runbook, or take everything you hold for them out of ITFlow in one zip.
where: Clients > a client > ⋮ > Export Data
---

There are two ways to export a client, both from **Export Data** in the **⋮** menu of the client's header:

- **Documentation PDF** - a printable runbook of their IT, to hand over or keep on file.
- **Full export** - one zip with everything you hold for the client, for a handover, when they leave you, or for your own records.

Each export is recorded in the client's audit log, including whether passwords went out.

## Documentation PDF

![The Export window on Documentation PDF, with a box for each part of the documentation](cl-export.webp "Pick the parts to include - each shows how many records it holds")

The PDF has a cover, a contents page with page numbers, and an overview with the client's key contacts, service levels and how to reach you. Then comes a chapter for each part you tick: contacts, locations, vendors, networks with their IP addresses, assets by type, racks, licenses with their keys and who holds them, domains, certificates, services, credentials, files, and every document in full with its images.

1. Open the client and click **⋮ > Export Data**.
2. Leave **Documentation PDF** picked, and tick the parts to include. **All** and **None** tick or untick the lot.
3. Click **Download PDF**.

### What the PDF looks like

It opens with a cover, named for the client and who prepared it, and a contents page:

![The cover and the contents page of a client's documentation PDF](cl-export-pdf-cover.webp "The cover and contents - every chapter and section with its page number")

The overview has the client's details, key contacts, what is in the document and the service levels you work to, with how to reach you on the next page. Then each part you picked has a chapter of its own - here the networks, with every IP address on each:

![The overview page and the networks chapter](cl-export-pdf-overview.webp "The overview, and the networks with their address, gateway, DNS and DHCP range and each one's IP addresses")

Assets come grouped by kind - servers and storage, network equipment, power, workstations, phones, printers - each with its make and model, serial number, operating system or firmware, IP address, location and warranty. Every document follows in full, on its own pages:

![The assets chapter and a document in the PDF](cl-export-pdf-assets.webp "Assets by kind, and a document - the site runbook - in full")

After the cover, every page has the client's name at the top, and your company, *Confidential*, the date and the page number at the bottom.

## Full export

![The Export window on Full export, with switches for the PDF, archived records, internal notes and passwords](cl-export-full.webp "Full export: every record as a spreadsheet and as JSON, documents, files and ticket conversations")

The zip has:

- every record as a CSV spreadsheet, and as JSON for moving to another system
- documents as web pages in their folders, and files in their folders under their own names
- tickets and projects, with the ticket conversations and their attachments
- invoices, quotes and payments
- photos, the documentation PDF, and a **README.html** that links it all together

### What is in the zip

Unzipped, it is one folder named for the client and the day. For Ravenwood Dental Group it looks like this - a folder marked *(if any)* is only there when the client has something to put in it:

```
Ravenwood Dental Group - Export 2026-10-27/
├── README.html
├── Ravenwood Dental Group - IT Documentation - 2026-10-27.pdf
├── data/
│   ├── export.json
│   ├── csv/
│   │   ├── assets.csv
│   │   ├── asset_interfaces.csv
│   │   ├── contacts.csv
│   │   ├── credentials.csv
│   │   ├── invoices.csv
│   │   ├── networks.csv
│   │   ├── tickets.csv
│   │   ├── ticket_replies.csv
│   │   └── ...             one for each kind of record
│   └── json/
│       └── ...             the same records, as .json
├── documents/
│   ├── RDG - Backup and Recovery Plan.html
│   ├── RDG - Getting Help.html
│   ├── RDG - Site Runbook.html
│   ├── RDG - Vendors and Escalation.html
│   └── _images/            the documents' images (if any)
├── files/
│   ├── Main Office network.png
│   └── Contracts/
│       └── Managed Services Agreement - signed.pdf
├── tickets/
│   ├── TCK-93 - Site internet dropping intermittently.html
│   ├── TCK-94 - New starter setup - workstation, mailbox and access.html
│   ├── ...                 one for each ticket
│   └── attachments/        a folder for each ticket (if any)
└── photos/                 (if any)
    ├── assets/
    ├── contacts/
    ├── locations/
    └── racks/
```

| In the zip | What it holds |
|---|---|
| **README.html** | Start here. It says when the export was made, by whom and what is in it, and links every part: each set of records with how many rows it has, and every document, file and ticket. |
| **The PDF** | The documentation PDF, when **The documentation PDF** is switched on. |
| **data/csv** | One spreadsheet for each kind of record - assets, contacts, tickets and their replies, invoices and so on - that opens in Excel, Numbers or LibreOffice. Linked records are named, not numbered: an asset's location and who uses it, a ticket's contact. |
| **data/json** | The same records as JSON, for moving them into another system. **data/export.json** describes the export: when and by whom it was made, what is in it and what isn't, and the columns of each set. |
| **documents** | Each document as a web page, in the same folders as in ITFlow, with its images in **_images**. |
| **files** | The client's files, in their folders, under their own names. |
| **tickets** | Each ticket as a web page - its details and the whole conversation - with its attachments in **attachments**, a folder for each ticket. Your team's internal notes are only there when **Internal notes** is switched on. |
| **photos** | Photos of the client's contacts, locations, assets and racks, named for each. |

**README.html** opens in any browser, so the client can find their way around without ITFlow:

![The README.html page of a full export](cl-export-readme.webp "README.html: what is in the export, and every set of records with its row count and links to the CSV and JSON")

Each ticket opens as a page of its own, with its details and conversation:

![A ticket's page in a full export](cl-export-ticket.webp "A ticket from the export: its contact, asset, project and vendor, the time worked and the whole conversation")

Under the parts to include are switches for **The documentation PDF**, **Archived records** (marked with when they were archived), **Internal notes** (your team's ticket notes and the client's quick notes) and **Passwords and 2FA secrets**.

1. Open the client and click **⋮ > Export Data**, then **Full export**.
2. Tick the parts and set the switches.
3. Click **Download ZIP**.

## Passwords

Passwords and 2FA secrets are left out unless you ask for them. When you include them, you set a password for the file, and the PDF or zip is locked with it (AES-256 encryption). Give the client the password separately - by phone, say - not in the same email as the file.

> [!WARNING]
> An encrypted zip opens with 7-Zip, WinRAR, Keka or The Unarchiver. The zip tools built into Windows and macOS can't open it.
