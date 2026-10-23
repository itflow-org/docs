---
title: After installing
description: The first things to do once ITFlow is installed - turn cron on, keep the backup key, connect mail, schedule backups, and add starter content and your team.
access: Admins
---

ITFlow is running, but some of it is switched off until you set it up. Do these in order.

## 1. Turn cron on {#cron}

Cron runs ITFlow's background work: sending email, turning email into tickets, watching SLAs, making recurring invoices and tickets, and backups. The cron entry runs every minute, but ITFlow comes with cron switched off, so every job stops straight away until you turn it on.

1. Go to **Admin > Cron**.
2. Check it says **Cron last checked less than a minute ago**. If it says **Cron is not running**, the cron entry is missing. The page shows the line to add.
3. Click **Turn cron on**.

[Cron](/admin/maintenance#cron) describes each job.

## 2. Keep the backup key safe {#backup-key}

Every backup is locked with a key. Without it, nobody can restore a backup. Not you, and not the ITFlow project.

Copy the **Encryption Key** from **Admin > Backup** into your password manager, or somewhere else away from this server. Setup showed you the same key on its last step.

## 3. Connect mail {#mail}

ITFlow needs a mailbox to send from: invoices, quotes, ticket replies and notifications. It can also turn email to your support address into tickets. Set both up in [Admin > Settings > Mail](/admin/mail), then turn on [email to ticket](/admin/tickets#email-to-ticket).

## 4. Schedule backups {#backups}

Scheduled backups start switched off, because a full backup can be large.

1. In [Admin > Backup](/admin/maintenance#backup), choose the type to make each night and how long to keep them, under **Scheduled Backups & Retention**.
2. In **Admin > Cron**, turn on the **Backup** job and set its time.
3. Copy backups off the server too - a backup on the same disk is lost with it. A snapshot of the whole VM is even better.

## 5. Add starter content {#starter-content}

[Admin > Starter Content](/admin/maintenance#starter-content) adds ready-made categories, tags, ticket and project templates, canned responses, document templates, vendor and license templates, and products. Pick the packs you want. Adding them never changes anything you already have.

## 6. Finish your settings {#settings}

Go through [Admin > Settings](/admin/settings): your logo and company details, [invoices and billing](/admin/billing), [taxes](/admin/taxes) and [tickets](/admin/tickets).

## 7. Add your team {#team}

Check the [roles](/admin/roles) fit how your team works, then invite everyone from [Admin > Users](/admin/users).

## When you're ready

- Take card payments: [Card payments with Stripe](/admin/payment-providers)
- Let clients sign in: [Client portal settings](/admin/client-portal) and [Giving contacts access](/portal/access)
- Connect an AI model: [AI providers and models](/admin/ai)
- Connect your RMM or scripts: [API keys](/admin/api-keys)
- Send logs to your SIEM: [Logs](/admin/logs#keeping-and-forwarding-logs)
