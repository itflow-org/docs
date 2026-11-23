---
title: Calls
description: Every call from your phone system with the contact it was with, the extension that took it and how long you talked - and putting a call on a ticket with its talk time.
where: Calls
access: Agents with access to Support
---

**Calls** lists the calls your phone system sends ITFlow. It's under **Support** once an admin has set up a [phone system](/admin/phone-systems), and each client has its own **Calls** once it has had a call. The number beside **Calls** in the menu is the calls missed today that aren't on a ticket.

![The Calls list with inbound, outbound, missed and voicemail calls](doc-calls.webp "Calls: who each one was with, who took it, when and how long")

Each row shows:

- **Call** - who it was with: the contact, matched by their number, else the caller ID name or the number. Under it, which way it went and, when nobody answered, **Missed**, **Voicemail**, **Busy** or **No answer**.
- **Client** - the contact's client, or the client whose main number it is.
- **Taken by** - the extension, and the agent whose desk phone it is.
- **When** and **Talked** - when it started and how long you talked.
- **Ticket** - the ticket it went on.

The tabs show **Inbound**, **Outbound**, **Missed** (missed and voicemail) and **Unknown** - numbers that aren't a contact's. Search finds a call by the contact, the caller ID name, the client, the extension, the agent or part of the number.

The button at the end of a row opens the call's page in FusionPBX, with its recording.

## Put a call on a ticket {#ticket}

Click **Add to Ticket** on the call.

1. Pick one of the client's open tickets. The contact's own tickets come first, and the one they're on is picked to start with. For a caller ITFlow doesn't know, any client's open ticket can be picked.
2. Leave **Count the call as time worked** on to log its talk time, rounded up to the minute, with when the call started and ended.
3. Add a note about what the call was about, if you like.
4. Click **Add to Ticket**.

An internal note on the ticket says what the call was - **Inbound call from Marla Whitfield (+1 (412) 555-0100) on ext 101, 4m 12s.** - followed by your note. A call to a voicemail box logs no time.

**New Ticket** in the same window opens New Ticket with the client, the contact and the call filled in. The ticket is made with the call on it, its talk time logged, and its source set to Phone.

A caller ITFlow didn't know becomes the ticket's client and contact, so their next calls are easier to place - add their number to the contact to have ITFlow know them.

## On a contact {#contact}

A contact's page has a **Calls** tab with their latest calls, each with **Add to Ticket**. **All** opens Calls with just theirs.
