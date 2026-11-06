---
title: Text messaging
description: Text clients from one support number through Skyetel - set it up, have texts come back into ITFlow, text clients about their tickets, visits and invoices, and see who opted out and every text sent and received.
where: Admin > Text Messaging, Admin > Text Messages
access: Admins
---

ITFlow texts through Skyetel, from one support number. Once it's set up:

- Agents answer a ticket by text with **Text reply** - see [Working a ticket](/service-desk/working-a-ticket#reply).
- A text from one of your contacts opens a ticket, and what they text next goes on it - see [Text to ticket](/admin/tickets#text-to-ticket).
- Texts from anyone else, verification codes and spam wait in **Texts** - see [Texts and verification codes](/service-desk/texts).
- Contacts who agree to texts hear about their tickets, visits and invoices - see [Texts to clients](#texts-to-clients).

## Before you start

You need, in [Skyetel's portal](https://portal.skyetel.com):

- A number with **SMS** turned on. A number has to be in a good state before Skyetel lets you turn it on.
- For a US number, its **SMS registration** done. Carriers block texts from a US number that isn't registered. Canadian numbers don't need it.
- An API key - the gear at the top right, then **API Keys**. It gives you a **SID** and a **Secret**. The secret is shown once, so copy it then.

## Set it up

1. In **Admin > Text Messaging**, click **Add Provider**.
2. Enter the **Number texts go from**, with its dial code (+1 412 555 0100), and the **SID** and **Secret**.
3. Click **Add**. If anything is wrong, it says so beside the field, and nothing is saved until it's right.
4. Copy the address in **Texts come back to** with the copy button.
5. In Skyetel's portal, open the number, then its **SMS** tab. Send texts to a **Callback URL**, paste the address, and pick **POST**.
6. On the provider's menu, click **Send a test text** and send one to your own mobile.
7. Text the number back from your mobile. It shows in **Texts > Unmatched** on the agent side, as your mobile isn't a contact.

> [!NOTE]
> The address carries a key, so only Skyetel can post texts to it. If it gets out, use **New inbound address** on the provider's menu, then paste the new one into Skyetel's portal. The old one stops working at once.

## The provider

The list shows the provider, whether it's on, its number, the address texts come back to, and when the last text came in. Above it are the texts sent, failed and received in the last 30 days.

From a provider's menu:

- **Edit** - its number, SID and secret. Leave the secret empty to keep the saved one.
- **Send a test text** - to any number, through Skyetel, for real.
- **New inbound address** - a new key for the address texts come back to.
- **Turn off** - nothing is texted, and texts to the number aren't taken in. Texts waiting to go wait until it's on again.
- **Delete** - nothing more is texted, and texts to the number stop reaching ITFlow. The texts already sent and received stay in the log and on their tickets.

## Texts to clients {#texts-to-clients}

ITFlow can text your clients about their work, as it emails them. Nobody gets these texts until they agree - see [Who gets them](#who-gets-them).

Choose what's texted in **Admin > Settings > Notifications > Texts to clients**:

| Setting | What's texted |
|---|---|
| **Text them about their tickets** | When a ticket is opened for them and when it's resolved - or those and each reply an agent emails them. Not for a ticket they opened by text, which already got its number. |
| **Text them when a visit or call is booked** | When a visit or remote work is booked on their ticket, and when it's cancelled. |
| **Remind them of a visit or call** | An hour, two hours, four hours or a day before. |
| **Text invoices and payment reminders, with a link to pay** | With the email, to the people it's emailed to who agreed to texts - when you send an invoice, when a recurring invoice sends itself, and with the payment reminders. |

Texts about a ticket go to the ticket's contact. Replying to one adds to the ticket, and replying to the resolved text opens the ticket again.

Texts ITFlow sends by itself that would land between 9pm and 8am, your time, wait for the morning. A reminder for an early visit goes when it's due. Texts an agent sends, like **Text reply**, go straight away.

### Who gets them {#who-gets-them}

A contact gets these texts once they've agreed, and has a mobile number. There are three ways:

- **On their contact** - on the **Roles** tab, turn on **Texts**, when they've told you they want them.
- **Ask them by text** - on the contact's page, next to **Texts**. They're texted asking whether texts are all right, and replying **YES** within a week turns them on.
- **In the client portal** - under **Your account**, they turn on **Text me about my tickets, visits and invoices**.

The contact's page shows when and how they agreed, as a record. If they replied STOP, it says so, and nothing is texted until they text START or turn texts on in the portal.

## STOP, START and HELP {#keywords}

Carriers expect texts like these answered, and ITFlow answers them for you:

| They text | What happens |
|---|---|
| **STOP**, **UNSUBSCRIBE**, **CANCEL**, **END** or **QUIT** | They're told they won't get more texts. Nothing more is texted to the number until it texts **START**, and **Text reply** is greyed out on their tickets. |
| **START** or **UNSTOP** | They're told texts are back on. |
| **HELP** or **INFO** | They're told your company's phone number and email, and how to stop texts. |

Each is noted on the ticket they're texting on.

**Opted out and blocked** lists the numbers that replied STOP, and the ones an agent marked as spam. **Opt back in** is for someone who asked for texts again by phone, email or in person. **Unblock** lets a number's texts come in like any other.

## Every text sent and received {#log}

**Admin > Text Messages** lists every text, newest first. Use the tabs for **Waiting**, **Failed**, **Sent** and **Received**, and search by number, words, contact, client or ticket.

Each text shows where it stands:

- Going out: **Waiting**, **Sent**, **Failed** with why, or **Not sent** because they replied STOP.
- Coming in: **On a ticket** (with a link to it), **In Texts**, **Code**, **Spam** or **Keyword**.

A text that failed can be retried, and one waiting can be cancelled. Tick several to do it to all of them.

A text that can't go is tried three times, a couple of minutes apart. Texts go one a second, as Skyetel allows. The **Text Messages** job in [Maintenance > Cron](/admin/maintenance#cron) sends the ones waiting.

> [!NOTE]
> Verification codes are masked here. Only [Texts > Codes](/service-desk/texts#codes) reveals them.

## How long texts are kept

| Text | Kept |
|---|---|
| A verification code's words | A day. That a code came from that sender is kept. |
| Spam and dismissed texts | 30 days |
| Everything else | A year |

A text that went on a ticket stays on the ticket as a reply, however long the log keeps it.
