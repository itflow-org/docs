---
title: Using AI
description: Where ITFlow's optional AI helps - rewording replies, drafting and summarizing tickets, client briefings, documents and quotes - and what it does and doesn't see.
where: Throughout ITFlow, once your admin has set it up
---

AI in ITFlow is optional. When your admin has connected an AI provider - a service such as OpenAI or Claude, or a model on your own server - you'll see an **AI** button or a **with AI** option in a few places. Everything it writes is a draft for you to check: nothing is sent, saved or charged until you say so.

Your role decides whether you can use it. If you don't see the buttons below, AI isn't set up, or your role doesn't include it.

## In any editor

Every text editor - ticket replies, notes, documents - has an **AI** button in its toolbar. Select some text (or none, for all of it) and pick what you want:

![The AI menu in a reply editor](ai-reword-menu.webp "The AI button: reword, shorten, make it friendlier or more formal, or translate")

- **Reword - clearer and more professional**, **Make it shorter**, **More formal**, **Friendlier**, **Plain English, for someone non-technical**
- **Organize it - headings and lists**, for a wall of text
- **Just fix spelling and grammar**
- **Translate...** into another language

The text is replaced in one step, so <kbd>Ctrl</kbd>+<kbd>Z</kbd> puts back what was there.

## On a ticket

**Draft** in the reply editor writes the next reply for you - from the ticket so far, or from your own notes if you've typed some, such as "line fault, provider coming Thursday". It writes for whoever will read it: a technical note for your team, or a friendly reply for the client. Where only you know something - a time, a name - it leaves a gap in [square brackets] for you to fill in.

![A reply drafted with AI](ai-draft.webp "Draft: a reply written from the ticket, with a gap left for what only you know")

From the ticket's **⋮** menu:

- **Summarize with AI** - the problem, what's been done, where it stands and what's next, so you can pick a ticket up cold. **Save as a note** keeps it on the ticket.
- **Triage with AI** - suggests a category and priority, for you to apply or dismiss. Your admin can have new tickets triaged as they come in.
- **Write up as a document** - turns a solved ticket into a how-to for the client's documentation, for next time.

![An AI summary of a ticket](ai-summary.webp "Summarize with AI: what the problem is, what's been done, and what's next")

## Before a call or a review

**Briefing** on a client's overview reads what ITFlow has on them - open tickets and what keeps coming up, renewals, money owed - and writes a one-page briefing, with things worth bringing up. Pick **Last 30 days**, **Last quarter** or **Last year**. **Save as a document** keeps it in the client's files.

![A client briefing](ai-briefing.webp "Briefing: how things stand with a client, before a call, a visit or a quarterly review")

## Documents

- **Draft it with AI** on a new document writes a first draft from what you say it's for, using what ITFlow knows about the client - its sites, devices and services. See [Files and documents](/documentation/files-and-documents#write-a-document).
- **Review with AI** on a document reads it as a senior engineer would, and points out what looks wrong, missing or out of date.

## Quotes and invoices

**Write it with AI**, under the lines of a draft quote or invoice, turns a sentence such as "three new laptops for the new starters, set up and joined to the domain" into lines. It picks items from your catalog, adds labor in hours at the client's rate, and sizes per-user lines from the client's numbers.

![Writing a quote's lines with AI](ai-quote-writer.webp "Write it with AI: lines from your catalog and labor at the client's rate, to check before adding")

Prices always come from your catalog and the client's rate - AI never sets one. It tells you what it guessed, and what to confirm before you send. Change or untick any lines, and add them to the quote or invoice.

When you bill a ticket with **Create invoice**, **Write it** describes the work done in plain words for the client.

## What it sees

- Only what's needed for the job: the ticket, the document, or the client's records you asked about.
- Passwords, PINs, API keys and similar secrets are taken out before anything is sent, and put back in the answer - unless your admin has turned that off for a provider on your own network.
- Every request is recorded - who asked, about which client, and when - in **Admin > AI Usage**.

Your admin sets up providers and models in **Admin > AI Providers** - see [AI](/admin/ai).
