---
title: Client portal settings
description: Two-step sign-in for portal contacts, letting people sign up, signing in with Microsoft 365, and announcements on every client's portal home page.
where: Admin > Settings > Client portal
access: Admins
---

The client portal mostly looks after itself: who sees what comes from each contact's roles (see [Giving contacts access](/portal/access)), and your request forms come from [ticket templates](/admin/ticket-templates#client-portal). The admin side has four things.

![Client portal settings](adm-client-portal.webp "Client portal: two-step sign-in for contacts, and announcements")

## Two-step sign-in

Switch on **Require two-step sign-in** and contacts who sign in with a password are asked for a code from an authenticator app too. Anyone who hasn't set it up is taken to set it up before anything else. Contacts who sign in with Microsoft 365 are left to Microsoft.

If a contact loses their phone, turn it off for them from their contact page - see [Giving contacts access](/portal/access#signing-in-safely).

## Signing up {#signing-up}

Switch on **Signing up** to let the people at a client make their own portal account from the sign-in page, with an address at one of the client's domains. It's off for every client until you turn it on for one, with **Let them sign up** on the client's **Contacts > Invites**. This section lists the clients that let people sign up, and their domains.

They prove their address with an emailed link, and join as a plain contact who sees the tickets they raise. You and the client's primary contact are told. See [Invites and signing up](/portal/invites#sign-up).

## Signing in with Microsoft 365

**Admin > Settings > Single sign-on** lets contacts sign in to the portal with their Microsoft 365 work account, instead of a password.

![Single sign-on](adm-sso.webp "Single sign-on: contacts sign in with their Microsoft 365 account")

1. In Microsoft Entra, register an app for ITFlow, for accounts in any organisation's directory. Under **Authentication**, add the **Redirect address** this page shows, as a Web platform.
2. Copy its **Application (client) ID** from the app's Overview, and make a **Client secret** under **Certificates & secrets**. Paste both here - the secret's Value, not its ID - and save.
3. On each contact who should use it, set **Login** to **With their Microsoft (Entra ID) account**.

A contact's Microsoft email has to be their email in ITFlow. A client secret runs out - put the new one here before it does.

## Announcements

An announcement shows at the top of the portal's home page - planned maintenance, a holiday closure, a security warning - to every client, or one.

1. Click **New Announcement**.
2. Give it a **Title** and a **Message** - what's happening, when, and what they need to do. Web addresses become links.
3. Pick how it's **Shown**: **Notice**, **Heads up** or **Urgent**.
4. Pick who it's **For**: every client, or one.
5. Set when to **Show from** and **Until**. Empty, it shows straight away and until you archive it.
6. Click **Post Announcement**.

![A new announcement](adm-announcement-new.webp "New Announcement: what to tell clients, how loudly, and for how long")

**Current** lists what's showing or still to come, and **Archived** the ones that are over.
