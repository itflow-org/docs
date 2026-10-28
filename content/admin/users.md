---
title: Users
description: The agents who sign in to ITFlow - inviting them, their role and the clients they see, two-step sign-in, and what to do when someone leaves.
where: Admin > Users
access: Admins
---

Users are your team: everyone who signs in to ITFlow to work. (Your clients' contacts sign in to the client portal instead - see [Giving contacts access](/portal/access).)

![The users list](adm-users.webp "Users: each agent's role, how they sign in, the clients they see and when they last signed in")

Each row shows the agent, their **Role**, whether they can sign in and how (with or without two-step sign-in), the **Clients** they can see, and when they **Last signed in** and from where. The tabs show **Users**, **Admins**, **No MFA** (not using two-step sign-in), **Disabled**, **Invited** (people asked to join who aren't in yet) and **Archived**.

Your own row can't be changed here - that's your [account](/getting-started/account) - so you can't lock yourself out by mistake.

## Invite someone

You invite people rather than set a password for them: they're emailed a link, and choose their own password when they join. Nobody else ever knows it - their password also unlocks their copy of the [credential vault](/documentation/credentials) - so there's no password to pass on, write down or email.

1. Click **New User**.
2. On **Details**, add their **Name**, the **Email** they sign in with, and their **Role** - what they can see and change (see [Roles](/admin/roles)). A picture is optional.
3. On **Sign in**, leave **Invite them** picked. Switch on **Require it** under **Multi-factor authentication** to make them set up two-step sign-in as they first sign in.
4. On **Client access**, limit them to some clients if you need to (see below).
5. Click **Send invite**.

![The New User window](adm-user-new.webp "New User: their details and role, how they get in, and which clients they see")

![New User's Sign in tab](adm-user-invite.webp "Sign in: invite them - they choose their own password - or set one now")

They get an email from you with **Accept the invite**. Until they use it, they're on the **Invited** tab, not your list of users. The link works for 7 days.

> [!NOTE]
> With no email set up, **Invite them** gives you the link instead, at the top of **Users** - send it to them yourself, by chat, text or your own email. It's only shown that once. To set up email, see [Mail](/admin/mail).

**Set a password now** is still there, if you'd rather: type one, or make one up with the wand, and give it to them yourself - nothing is emailed. They should change it once they're in.

### Joining

The link opens a page that says who invited them and as what. They check their name, choose a password - twice - and click **Join**. From then they're an agent with the role, two-step sign-in and clients you set, and sign in on the usual page. You're notified in ITFlow, and their quick look says whose invite they joined from.

![Joining from an invite](adm-user-join.webp "The page the invite opens: their name and their own password")

A link that has run out, been used or cancelled says so, and who to ask for another.

### Invites waiting

The **Invited** tab lists everyone invited who hasn't joined yet - their role, whether the link is still good or has **Run out**, two-step sign-in, the clients they'll see, and who invited them and when it was emailed.

![Invites waiting](adm-users-invited.webp "Invited: who is asked to join, and whether their link is still good")

From a row's menu:

- **Send again** emails them a new link, good for another 7 days. The one sent before stops working.
- **Get the link** makes a new link for you to send them yourself, shown once at the top of the page. The one sent before stops working.
- **Cancel invite** stops the link working.

![An invite link to pass on](adm-user-invite-link.webp "Get the link: shown once, to send them yourself")

To change an invite - a different role, say - use **New User** again with the same email. Their invite takes what you set now, and they're sent a new link.

If your installation has a limit on agents, an invite waiting holds a seat until it's accepted, cancelled or runs out, so there's one for them when they join.

## Which clients they see

By default an agent sees every client. On **Client access** you can set each client to:

- **Only** - limits them to the clients marked Only. With none marked, they see every client.
- **Never** - keeps them out of that client, whatever else is set.

This suits a contractor who looks after one client, or keeping a sensitive client to a few people. Admins always see every client.

## Two-step sign-in

The **No MFA** tab shows who isn't using two-step sign-in. Tick users and use **Bulk Action > Require MFA**: they're asked to set it up at their next sign-in, and can't turn it off.

If someone loses their phone, open them with **Edit** and use **Reset it** under **Multi-factor authentication**. Their authenticator app and their remembered browsers are forgotten, and they set it up again.

**Forget remembered browsers**, in the bulk menu, makes them enter a code again everywhere.

## When someone leaves

- **Disable** stops them signing in, and keeps everything as it is - for someone on leave.
- **Archive** is for good. They're signed out and can't sign in, their password and copy of the credential vault key are wiped, and you hand their open tickets to someone else - or leave them unassigned. Everything they did stays, under their name.

> [!WARNING]
> If an agent's account may have been compromised, use **Incident response** in the menu beside **New User**. It resets the password of every other agent, shows you the new passwords once to give out by phone, and forgets every remembered browser. Client portal logins are left alone. Change your own password first.

## Sign-ins

**Admin > Sign-ins** shows who signs in and from where: each agent and portal contact with their last sign-in, how many sign-ins and failed ones, and how many addresses they've used. The **IP addresses** tab shows each address, the accounts it tried, and whether it's being turned away now.

![Sign-ins](adm-sign-ins.webp "Sign-ins: who signs in, from where, and the failures")

Click one to see its sign-ins in the audit log. **Alerts** sets when admins are told about failed sign-ins - see [Security](/admin/security).
