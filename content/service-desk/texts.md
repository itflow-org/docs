---
title: Texts and verification codes
description: The texts to your support number that aren't on a ticket - unknown numbers to open a ticket from, verification and MFA codes, and spam.
where: Texts
access: Agents with access to Support; Codes for agents who can view credentials
---

**Texts** holds what comes to your texting number that isn't on a ticket. A text from one of your contacts, or about a ticket that's being texted on, goes on its ticket and never waits here. It's under **Support** once an admin has set up [text messaging](/admin/text-messaging).

The number beside **Texts** in the menu is the texts in **Unmatched**, plus the codes that came in the last 15 minutes if you can see them.

## Unmatched {#unmatched}

Texts from numbers that aren't a contact's.

- **Open ticket** - pick the client and contact, and give it a subject. Every unmatched text from the number in the last two weeks goes on the ticket, with any photos. What the number texts next goes on it too. Leave **Save the number as their mobile** ticked, so their next text finds them. **Assign it to me** is on by default.
- **Dismiss** - it leaves the list.
- **Name this number** - a name shown with it in Texts and the text log.
- **Mark as spam** - blocks the number. Its texts here move to **Spam**, and what it sends later goes straight there.

> [!TIP]
> An admin can have texts from unknown numbers open tickets with no client instead, with **From unknown numbers too** in [Text to ticket](/admin/tickets#text-to-ticket). Codes and spam still wait here.

## Codes {#codes}

Verification and MFA codes texted to your number, such as Microsoft, Google or Duo sign-in codes. They're kept out of tickets, and only agents whose role can view credentials see this tab.

- Each code is masked. Click **Reveal** to see it and its text, then copy it.
- Every reveal is in the audit log, with who revealed it.
- A code can be revealed for 15 minutes after it came. After that it shows **Expired** - ask for a new one.
- A code's words are wiped a day after it came.
- The list comes up to date by itself when a new code lands.

**Name this sender** puts a name such as "Microsoft" on a short code, so it's clear which code is which. If something here isn't a code, **Not a code** moves it to Unmatched, where everyone who works tickets can read it.

> [!NOTE]
> Some services won't text codes to a VoIP number like Skyetel's, so a code may never arrive. Skyetel's own advice is not to rely on its numbers for other services' sign-in codes.

## Spam {#spam}

Texts from blocked numbers, and ones that look like bait, such as shortened links or "your package couldn't be delivered". They're deleted after 30 days.

- **Not spam** - unblocks the number and moves its texts to Unmatched.
- **Delete** - takes it off now.
