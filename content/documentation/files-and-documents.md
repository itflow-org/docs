---
title: Files and documents
description: A client's written documentation and uploaded files in folders - runbooks, procedures, diagrams, contracts - with versions, reviews and templates.
where: Clients > a client > Files
---

**Files** holds two kinds of thing, side by side in the same folders:

- **Documents** - pages written in ITFlow: runbooks, procedures, how-tos, onboarding checklists. They're searchable, have versions, can be shared and shown in the client portal.
- **Uploads** - files you upload: PDFs, diagrams, photos, spreadsheets, signed contracts.

## Find your way around

![A client's Files in grid view, with folders, a diagram and documents](doc-files-grid.webp "Files in grid view: folders on the left, a preview of each file and document")

- **Folders** are down the left, with how many items each holds. The buttons above them expand or collapse the tree and add a folder.
- The tabs show **All**, **Documents** or **Uploads**. A **Review due** tab appears when documents are due a review.
- **Search all folders** searches every folder at once - names and the text of documents - and shows where each result lives.
- The list and grid buttons switch views. The grid shows real previews: image thumbnails, the first page of a PDF, the start of a document. Click one to open the previewer, and use the arrow keys to move between files.
- Markers show which items are shared by link and which are visible in the client portal.

To upload, drag files or folders from your computer onto the list - they go into the folder you're in - or onto a folder on the left to put them there. Or click **Upload**.

![A client's Files in list view](doc-files.webp "List view: each item's type, size, when it changed and what it's linked to")

Tick items and use **Bulk Action** to move, tag, archive, restore or delete them together, or **Download as zip** to get them in one go.

To rename something in the list view, point at it and click the pencil beside its name. Type the new name and press <kbd>Enter</kbd>, or <kbd>Esc</kbd> to leave it. For a file, the name is picked out without its extension, so you can type straight over it.

### Download a folder {#zip}

The **⋮** beside the folder's path has **Download as zip**: everything in the folder and the folders under it, in the same folders. At the top level it's **Download everything as zip**. Documents go in as web pages, which open in any browser. Archived items are left out, and one zip can hold up to 2 GB.

## Move things between folders {#move}

Drag things onto a folder to move them. The folder lights up when it can take what you're dragging.

![Two ticked files dragged onto a folder](doc-files-move.webp "Two ticked files dragged onto Diagrams, which lights up to take them")

- **A file or document** - drag it onto a folder on the left. Tick several first and drag one of them to move them all.
- **A folder** - drag it onto another folder to put it inside, with everything in it, or onto **Top level** to bring it out. A folder can't go inside one of its own folders.
- **A folder inside a closed one** - hold what you're dragging over the closed folder for a moment and it opens.
- **Up a level** - the path above the list takes a drop too. Drag onto **Top level** or a folder in the path.

Each move goes in the audit log, and the message after it has [Undo](/getting-started/lists#undo) to put things back where they were. On a phone or tablet, use **Move** in an item's **⋮** menu, or **Rename or move** in a folder's.

## Upload files

1. Open the folder to put them in and click **Upload**.
2. Drop files onto the box, or click it to choose them. The window lists them and checks their size before anything is sent, and tells you about any it skipped.
3. Pick the **Folder** and add a description if you like.
4. Click **Upload**.

![The Upload window](doc-upload.webp "Upload: drop files in, pick the folder, and upload")

### Upload a folder {#upload-folder}

To upload a whole folder with the folders inside it, click **Choose a folder** in the **Upload** window, or drop the folder onto the box or onto the list. The folders are made inside the folder you pick, each file goes into its own, and files go into folders that are already there when the names match. Files your computer keeps beside your own, such as `.DS_Store` and `Thumbs.db`, are left out.

A folder goes up 20 files at a time, so it can be bigger than an upload of files - up to 1,000 files and 2 GB. The window counts them as they go, and says at the end how many went up and which were skipped.

Click a file to open its quick look: a preview, its folder, who uploaded it and when, whether it's shared, and what it's linked to.

## Write a document

1. In **Files**, use the arrow beside **Upload** and pick **New document**.
2. Give it a **Name** and a summary, pick its folder, and write it in the editor. Tables, images and formatting all work.
3. Click **Create**.

With AI set up, **Draft it with AI** writes a first draft from what you say it's for, using what ITFlow knows about the client. See [Using AI](/getting-started/ai).

**Edit**, on the document's page, opens it on a page of its own: the name, summary, tags and client portal switch along the top, and the editor filling the rest of the window. Long documents scroll inside the editor, so its toolbar stays in view. **Save** keeps what it said before as a version and goes back to the document. **Cancel** goes back without saving, and leaving with changes not saved asks first.

### Start from a template

Your admin can keep **document templates** - a network overview, a backup runbook, a new starter checklist - that fill themselves in from the client. Use **Document from template** in the same menu:

1. Pick the **Template**.
2. ITFlow shows what it fills in from the client - their name, sites, contacts, and tables of their networks, servers, domains, licenses and the rest, as they are now - and the **Site** to use.
3. Answer what it **asks for**, such as the internet provider or the firewall model. Leave one blank to fill in later.
4. Change the **Name** or **Summary** if you like, pick the folder, and click **Create**.

![New document from a template, with what it fills in and what it asks for](doc-from-template.webp "A document from a template fills in the client's records and asks for the rest")

When a template is required for the client - every managed client should have a network overview, say - Files lists the documents it should have across the top, each a click from making it. See [Document templates](/admin/document-templates).

## The document's page

![A document's page with its contents and the records linked to it](doc-document.webp "A document: what it says, and what it's linked to")

Along the top: **Edit**, **Share**, **PDF** and print, and the **⋮** menu with **Rename**, **Move**, **Copy**, **Link**, **Favorite**, **Show in client portal** (or **Hide from client portal**), **Copy to Knowledge Base**, **Archive** and **Delete**. **Copy to Knowledge Base** makes a draft [Knowledge Base](/service-desk/knowledge-base) article from it, for every client.

- **Contents** - a document with three headings or more has a list of them beside it. Click one to jump to it.
- **Linked** lists the assets, contacts, locations, licenses, vendors, services and files the document is about. Use **Link** to add more. A document linked to an asset shows on the asset's page, and so on.
- **Versions** keeps every earlier version. View one, restore it (the current one is kept as a version too), or delete it. See [What an edit changed](#changes).
- **Show in client portal** lets the client's technical contacts read it in the portal - for how-tos written for them.

### Copy a document {#copy}

**Copy** makes a copy for the same client - give it a new name and pick its folder - or for another client, the same runbook for a new site, say. A copy for another client goes in the top level of their files. The copy has the content, summary, tags and pictures, and is reviewed as often as the original. It isn't in the client portal or linked to anything, and starts with no versions.

### Favorites {#favorite}

**Favorite** puts a document on the client's [overview](/clients/overview), under **Favorites**, with their favorite assets, licenses and logins - for the network overview or the runbook you open on every call. A star marks it on its page and in **Files**. **Unfavorite** takes it off.

### What an edit changed {#changes}

The arrows beside a version in **Versions** - and beside **Now**, for the last edit - show what that edit changed, against the version before it. Lines taken out are red and lines put in are green. In a line that changed, the words that changed are marked. Lines that stayed the same are folded away, apart from a couple either side of each change. A change of name shows at the top. Formatting changes alone, such as bold or a colour, aren't shown, and a picture shows as **[Picture]**. **What changed** in a version's window opens the same view.

![What changed in an edit: a line taken out, a line put in, a line changed with its changed words marked](doc-changes.webp "What changed: taken out in red, put in in green, the changed words marked")

### Reviews

A document can be reviewed on a schedule - every 6 months, say. Its page then says **Review due**, or when the next review is and who last reviewed it, with **Mark reviewed**. Editing a document counts as reviewing it. The client's overview counts documents due a review, and Files has a **Review due** tab.

A document made from a template is reviewed as often as the template says. To change that for one document, or to review a document that isn't from a template, click **How often** beside its review and pick **Every 3 months**, **Every 6 months**, **Every year** or **Every 2 years** - or **Never**. **As its template says** puts it back. Changing it doesn't count as reviewing it.

![How often a document is reviewed](doc-review.webp "How often: as its template says, or set on the document")

## Share a document or file

**Share** sends a document or a file to someone outside ITFlow as a link that ends after a set time. Documents can be printed from the link, and files downloaded. See [Shared links](/documentation/shared-links).
