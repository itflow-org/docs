---
title: Running a public demo
description: Make an ITFlow a demo anyone can sign in to, like demo.itflow.org - one-click sign-in as each role, fresh demo data every night, and what visitors can't change.
access: Server admins
---

Demo mode makes an ITFlow a demo for anyone to try, like [demo.itflow.org](https://demo.itflow.org). Visitors sign in with one click, can try everything, and every night it goes back to fresh demo data.

> [!WARNING]
> Demo mode empties the database every night. Turn it on only for an ITFlow that holds nothing you want to keep - never for your own.

## Turn it on {#turn-on}

1. Install ITFlow as usual on its own server or hosting account, with its own database. See [Install with the script](/install/install-script) or [Install by hand](/install/manual).
2. Add its [cron job](/install/after-install), so it runs every minute.
3. Set the company's name, address and logo in [Company details](/admin/settings#company-details), and the timezone in [Localization](/admin/settings#localization). They stay as they are through every reset, and visitors can't change them.
4. Add this line to the end of its [config.php](/install/config-php#demo):

   ```php
   $config_demo_mode = true;
   ```

Within a minute, cron puts it back to fresh demo data for the first time. Everything in it is replaced, and anyone signed in is signed out. To do it straight away, run this in ITFlow's folder:

```bash
php cron/demo_reset.php
```

## What visitors see {#visitors}

The sign-in page has a button for each demo account:

| Button | Signs in as |
|---|---|
| Admin | Demo Admin, an administrator - `demo@demo.com` |
| Technician | Demo Technician, with the Technician role - `technician@demo.com` |
| Accountant | Demo Accountant, with the Accountant role - `accountant@demo.com` |
| Client portal | The primary contact at the first demo client, in the [client portal](/portal/overview). The page says who. |

Each account's password is `demo`, so the email and password still work too.

Every page has a note along the top: it's a demo, anyone can sign in so nothing real should go in it, when it goes back to fresh data, and that it sends no email or texts. Pages whose changes are turned off say so there as well.

## What goes back every night {#reset}

The **Demo Reset** job in [Admin > Cron](/admin/maintenance#cron) runs at 2:00 AM. It:

- empties the database and makes it again, as a new install
- loads all of the [starter content](/admin/maintenance#starter-content) and the twenty demo clients, with two years of tickets, invoices, documentation and finances up to that day
- makes the four demo accounts again
- empties the uploads folder, apart from the company's logo
- signs everyone out

It keeps the company's details, the timezone and each cron job's schedule.

## Updating the demo {#updating}

**Admin > Update** is turned off in the demo, so update it from the command line, in ITFlow's folder:

```bash
php scripts/update_cli.php
```

The reset builds everything from the code, so the next one makes the new version's database from scratch. To start visitors on it straight away, run `php cron/demo_reset.php` after updating.

## What visitors can't change {#locked}

Visitors can add and change anything an MSP would use day to day: clients, tickets, invoices, documentation, settings for tickets and invoices, and the rest. These are turned off, because they would reach outside the demo, cost money or lock other visitors out:

- users and roles, and each account's own name, email, picture, password and two-step sign-in
- sign-in security and identity providers
- mail settings, payment providers and card payments, AI providers and text messaging
- API keys, backups, updates, cron, log forwarding and telemetry
- the company's details, modules, client portal settings and custom links
- the starter content, the demo data and Get started
- share links, which would open what's in the demo to people who haven't signed in
- links that open without signing in - an invoice's or a quote's, a ticket's, the calendar feed. They still work, but only for someone signed in to the demo, so it can't be used to pass on what a visitor wrote.
- managed mode, and the Debug page

It sends no email: what would have gone shows in [Admin > Mail Queue](/admin/mail#the-mail-queue) as Cancelled, saying why. It sends no texts either. Certificate checks only reach public addresses on port 443, so the demo can't be used to look around the network it runs on.

If a visitor changes the client portal contact so the Client portal button can't sign in, the button puts it right the next time it's used.

## When a reset fails {#troubleshooting}

Admin > Cron shows the Demo Reset job's last status. If a reset stopped part way - the database server went away, say - the demo shows an error on every page, and cron can't run until the database is back. Run the reset by hand to put it right:

```bash
php cron/demo_reset.php
```

To stop being a demo, take the `$config_demo_mode` line out of config.php. The demo data stays until you [remove it](/admin/maintenance#starter-content), and the Demo Reset job no longer runs.
