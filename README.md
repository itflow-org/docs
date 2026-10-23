# ITFlow Docs

The user guide for ITFlow, for MSP staff: the service desk, client documentation, billing, finance, the client portal and administration, step by step with screenshots.

It's a small PHP site with no dependencies. Pages are Markdown files; the site adds the navigation, search, table of contents, screenshot zoom, and light and dark themes. It can be served by PHP, or exported once to plain HTML and put on any web host.

## What's where

| | |
|---|---|
| `content/<section>/<page>.md` | The pages - one Markdown file each |
| `content/index.md` | The home page |
| `nav.php` | The sections and pages, in order, with their titles in the menu |
| `config.php` | The site's name, address, version, top-bar links, and redirects from old addresses |
| `config.local.php` | Your own settings, if any - copy `config.local.example.php` |
| `assets/img/shots/` | The screenshots (WebP) |
| `assets/css`, `assets/js`, `assets/fonts`, `assets/vendor` | The look, search and zoom; Inter and Font Awesome, served locally |
| `includes/` | The Markdown renderer and the page layout |
| `index.php` | The router, when served by PHP |
| `build.php` | Exports the site to plain HTML, and checks links |

## Run it locally

```
php -S 127.0.0.1:8110 index.php
```

and open http://127.0.0.1:8110. It needs PHP 8.

## Writing a page

Each page starts with a few settings, then the text:

```markdown
---
title: Recurring invoices
description: One sentence on what the page covers - shown in search and to search engines.
where: Billing > Recurring Invoices
access: Admins
---

The first paragraph says what the thing is and why you'd use it.

## A heading

1. Numbered lists are shown as steps.
2. Name buttons and fields in **bold**, as ITFlow labels them.
3. A menu path in bold - **Admin > Settings** - gets arrows between its parts.
```

- `where` is shown at the top of the page as the way to get there in ITFlow. `access` (optional) notes who can use it.
- Headings `##` and `###` make the "On this page" list. A heading's link is its text in lower case with dashes - `## Bill per user, per device or per seat` is `#bill-per-user-per-device-or-per-seat`. Add `{#name}` after a heading to choose its own.
- Link to another page by its address in the docs: `[Recurring invoices](/billing/recurring-invoices#autopay)`. The links are made relative when the site is exported.
- A screenshot on a line of its own, with a caption in quotes:
  ```markdown
  ![What it shows, for screen readers](bill-recurring.webp "The caption under it")
  ```
  Screenshots are taken at twice their size on screen, and shown at their real size; click one to zoom.
- Callouts: start a quote with `[!NOTE]`, `[!TIP]`, `[!WARNING]` or `[!ACCESS]`:
  ```markdown
  > [!TIP]
  > Something worth knowing.
  ```
- Tables, `code`, code blocks and `<kbd>Ctrl</kbd>` work as usual.

### Adding a page

1. Write `content/<section>/<page>.md`.
2. Add it to its section in `nav.php`, with the title the menu shows.

A new section is a new folder in `content/` and a new entry in `nav.php`, with an icon (a Font Awesome name) and a one-line summary for the home page.

## Search

Search runs in the browser, over every page - no server or service needed. Its index is made from the pages as they are: by `index.php` when served by PHP, and by `build.php` in an export. <kbd>Ctrl</kbd>+<kbd>K</kbd> or <kbd>/</kbd> opens it.

## Check and export

```
php build.php --check          # broken links and headings, missing pages, unused screenshots - writes nothing
php build.php                  # exports to dist/
php build.php /var/www/docs    # exports there instead
```

The export is plain HTML with relative links: it works on any web host, from a folder, or opened straight from disk. It also writes a small page at each old address in `config.php`, so old links still land.

Run `--check` before publishing - it lists links to pages or headings that don't exist, and screenshots no page uses.

## Hosting

**Plain HTML** - export with `build.php` and upload `dist/`. Nothing else is needed.

**PHP on Apache** - put the folder in the web root. `.htaccess` sends every address to `index.php` and keeps the config, Markdown and includes from being served. `mod_rewrite` needs to be on.

**PHP on nginx**:

```nginx
server {
    server_name docs.itflow.org;
    root /var/www/itflow-docs;
    index index.php;

    location ~ ^/(includes|content|dist)/ { return 404; }
    location ~ ^/(config|config\.local|nav|build)\.php$ { return 404; }
    location ~ \.md$ { return 404; }

    location / { try_files $uri /index.php$is_args$args; }
    location = /index.php {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/index.php;
        fastcgi_pass unix:/run/php/php-fpm.sock;
    }
}
```

In a folder rather than at the top of the site, set `base` in `config.local.php`, such as `'/docs'`.

### Old addresses

`$redirects` in `config.php` sends old addresses on to pages here - the old wiki's pages, and the links inside ITFlow itself, such as Admin > Update's link to `/backups`. Each goes to `section/page#heading`, or to a full `https://` address elsewhere. `--check` warns when one points at a page or heading that doesn't exist.

## Screenshots

The screenshots are taken from a demo ITFlow - a fictional MSP, Summit IT Partners, and its clients - with the scripts in `tools/` (kept next to the site, not inside it). They use Python 3 with Playwright and Pillow.

| | |
|---|---|
| `tools/shots_spec.py` | Every screenshot: its name, the page, what to click or type first, and what part to keep |
| `tools/shots.py` | Takes them: `python3 shots.py`, or `python3 shots.py name1 name2`, or `python3 shots.py --prefix bill-` |
| `tools/shots_made.py` | The few that need something made first (a shared link, and the page the client opens), made and removed again |
| `tools/shots_setup.py` | The setup wizard's screenshots: copies ITFlow to a fresh folder with a database server of its own, walks through setup, then removes both. Run as root; it needs MariaDB's `mariadb-install-db` and `mariadbd`. |
| `tools/api_keys_make.py`, `tools/api_probe.py` | Check the API pages against ITFlow: make test keys, then call every endpoint as the pages describe and keep the responses. They add and delete records, so run them on a copy of the demo served at `localhost:8140`, never the demo the screenshots come from. |
| `tools/run_all.sh` | Tidies the demo's sign-in history and admin data, then takes every screenshot |
| `tools/ai_docs_mock.py` | A stand-in AI model for the AI screenshots, where Ollama listens - run it only while taking those |
| `tools/seed_admin.py`, `tools/tidy_logs.py` | Run by `run_all.sh` first: the admin pages' sample emails, and a tidy sign-in history |
| `tools/sheet.py`, `tools/review.py` | Contact sheets of shots, and screenshots of the docs site itself, for checking |

### The demo

`demo/` has the demo's database (`itflow_docs.sql.gz`) and its uploaded files (`uploads.tar.gz`), made with ITFlow 26.10 (database 3.3.9). To take screenshots:

1. Load the database into MySQL or MariaDB as `itflow_docs` - `zcat demo/itflow_docs.sql.gz | mysql itflow_docs` - and unpack the uploads into an ITFlow checkout at `/var/www/itflow` (the path the Cron and Backup pages show): `tar -xzf demo/uploads.tar.gz -C /var/www/itflow`.
2. Point that checkout's `config.php` at the database, with `$config_base_url = 'itflow.summitit.example';` so links in the screenshots show a real-looking address.
3. Serve it at `http://localhost:8100` - `php -S 127.0.0.1:8100 -t /var/www/itflow` is enough - and, for the AI screenshots, run `python3 tools/ai_docs_mock.py` alongside.
4. Run `tools/run_all.sh`, or `shots.py` for just some. The tools read the database with the `mysql` command, so it needs to sign in without a password prompt (a `~/.my.cnf`, say).

Taking screenshots signs in, opens client links and portal pages, and makes a shared link - all things ITFlow records. The tools clean up after themselves: the runs' own sign-ins, page views, notifications and invoice history are removed or given an ordinary browser and address, so the audit log and notifications in the screenshots look like a real team's.

The demo's records are dated around 21 October 2026, and ITFlow shows many times as "2 hours ago" or "in 3 days". Screenshots re-taken much later show those as older - fine for most pages, but worth knowing before re-taking the dashboard, tickets or notifications.

The demo's logins all use the password `Summit-Docs-2026`: `alex@summitit.example` (admin), `jordan@`, `priya@` and `sam@summitit.example`; and for the client portal, `mwhitfield@ravenwooddental.example` with `Portal-Docs-2026`. Its mail server, Stripe keys and AI model are stand-ins - nothing is sent anywhere.

Each entry in `shots_spec.py` looks like this:

```python
{'name': 'bill-send', 'url': 'agent/invoice.php?client_id=1&invoice_id=475',
 'steps': [('click', '.app-main .btn-primary[data-modal-url*="invoice_email.php"]'),
           ('waitfor', '.modal.show .modal-body'), ('wait', 900)],
 'clip': 'modal'},
```

- `clip` is `main` (the page, without the menus - trimmed of empty space at the bottom), `modal` (the open window), `viewport`, `full`, a CSS selector, or a list of selectors to keep the box around them all. `maxh` cuts it at that height, and `pad` adds space around it.
- `size` sets the browser window, in pixels on screen (default 1440 x 900, or 1280 x 1600 for a window).
- `who` signs in as `agent` (an admin), `jordan` (a technician) or `portal` (a client contact).
- `sql_before` and `sql_after` change the demo data just for that shot - such as marking a draft invoice sent for the portal's screenshots - and put it back.
- Steps: `click`, `clicktext`, `fill`, `type`, `press`, `hover`, `select`, `upload`, `submit` (click and wait for the next page), `scroll`, `wait`, `waitfor` and `eval` (run JavaScript).

Shots are saved at twice their size, no wider than 1600 pixels, as WebP.
