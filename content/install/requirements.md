---
title: Before you install
description: What ITFlow needs - a Linux server, PHP, MariaDB, a web server, a domain name and HTTPS - and the ways to install it.
---

ITFlow is a PHP web app with a MariaDB database. You run it on a server of your own: a virtual machine in your office, in a data centre, or at a cloud provider. A small VM is plenty for most MSPs. Two CPU cores and 2 GB of memory is a good start, with disk space for the files you upload and a few backups.

## What it needs

| Part | What it needs |
|---|---|
| **Server** | Linux. Debian 13 is what the install script is made for. Debian 12 and Ubuntu 24.04 work when you install by hand. |
| **PHP** | 8.2 or later, with the mysqli, intl, curl, mbstring, gd, xml, openssl and fileinfo extensions. Add zip for backups and client exports. |
| **Database** | MariaDB, or MySQL. ITFlow needs an empty database and a user that can create tables in it. |
| **Web server** | Apache with mod_php, which is what the install script sets up. nginx with PHP-FPM also works. |
| **git** | ITFlow updates itself with git, so install it with git rather than from a zip. |
| **cron** | One entry that runs every minute. It sends mail, reads the support mailbox, makes recurring invoices and tickets, and runs backups. |
| **PHP limits** | `upload_max_filesize` and `post_max_size` of 500M, and `max_execution_time` of 300, so you can restore backups and upload large files. |

The [setup wizard](/install/setup#checks) checks all of this before it starts, and says how to fix anything missing.

## A name and a certificate

Give ITFlow a domain name, such as `itflow.example.com`, that points at the server. Clients follow links in ITFlow's emails and sign in to the client portal, so they need to reach it by name.

ITFlow only lets you sign in over HTTPS. Free certificates from Let's Encrypt are fine, and the install script gets one for you. Let's Encrypt has to reach the server on port 80 to check the name is yours. Clients reach the portal on port 443.

ITFlow also connects out to other services: your mail server or Microsoft 365, GitHub for updates, and anything else you connect, such as Stripe or an AI provider.

## Ways to install

- **[With the install script](/install/install-script)** - recommended. One command on a fresh Debian 13 server installs everything, gets a certificate, and leaves you at the setup wizard.
- **[By hand](/install/manual)** - step by step on Debian or Ubuntu, with Apache or nginx. Use this to put ITFlow on a server you already run.
- **Another way** - a control panel such as HestiaCP, or a community Docker image. These can work if they give ITFlow what it needs, but expect to sort out problems with them yourself. [Install by hand](/install/manual#other-ways) lists what each needs to do.

## Have these ready

- A freshly installed server you can sign in to as root over SSH
- The domain name, already pointing at the server's public IP address
- Ports 80 and 443 open to the server
- Your company's name and country, and the email address you will sign in with

If anything goes wrong, see [When something goes wrong](/install/troubleshooting).
