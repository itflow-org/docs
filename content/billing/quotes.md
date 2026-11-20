---
title: Quotes
description: Put a price on work before you do it - one-off projects and monthly agreements - send it, let the client accept it online, and turn it into an invoice.
where: Billing > Quotes
---

A quote sets out what you'll do and what it costs, for the client to say yes or no to. It can hold what's billed once - hardware, a project - and what's billed every month, quarter or year, such as a managed services agreement. When the client accepts, one click turns it into an invoice and, for the monthly part, a recurring invoice.

## The quotes list

![The quotes list](bill-quotes.webp "Quotes: what's waiting for an answer, what's been accepted, and how many you win")

Along the top: what's **Awaiting answer**, what's been **Accepted** and is ready to invoice, what you've **Won** in the last 90 days and your **Win rate**.

The tabs are **All**, **Draft** (not sent yet), **Awaiting answer**, **Expired**, **Accepted**, **Invoiced** and **Declined**. Search by number, scope, client or amount, and narrow by date, category or client.

A quote moves through these statuses:

| Status | Meaning |
|---|---|
| **Draft** | Not sent yet - the client can't see it |
| **Sent** | Out with the client |
| **Viewed** | The client has opened it |
| **Accepted** / **Declined** | The client answered - online, or you marked it for them |
| **Invoiced** | It's been turned into an invoice |

A quote that passes its **Valid until** date shows **Expired** as well, and the client can no longer accept it online.

## Make a quote

1. Go to **Billing > Quotes** (or the client's **Quotes**) and click **New Quote**.
2. Type the **Scope** - what it's for, in a few words. It's shown on the quote and in lists.
3. Pick a **Category**, the **Quote date** and how long it's **Valid until** - the **15 days**, **30 days**, **60 days** and **90 days** links set it for you.
4. Add a **Discount** if there is one. It comes off the total, after the lines.
5. Click **Create**. The quote opens as a draft, ready for its lines.

![The New Quote window](bill-quote-new.webp "New Quote: what it's for, when it's valid until, and any discount")

### Add the lines

Lines go on a quote the way they do on an invoice. Under the lines, type in **Add a line** and pick an item from the catalog - it goes on with its price, description and tax, billed the way it's set up in the catalog - or type anything and pick **Add** for a one-off line. Then click a line's quantity, price or anything else on it to change it where it is. See [Add and change the lines](/billing/invoices#add-and-change-the-lines).

![A draft quote with one-time and monthly lines](bill-quote.webp "A quote with what's billed once and what's billed each month, kept apart")

- Each line is billed **One time**, or **Monthly**, **Quarterly** or **Yearly**. To change that, open the line's **⋮** menu and pick under **Billed** - the line moves under its heading. The quote shows the two apart - what's paid up front and what's paid each month - with a total for each.
- Drag a line by its handle to move it. Its **⋮** menu also has **Edit** and **Remove**.
- The **Notes** under the lines are shown on the quote - terms, what's included, what happens next.

![A quote line's menu, with how often it is billed](bill-quote-billed.webp "A line's menu: Edit, how often it's billed, and Remove")

### Your cost and margin {#cost}

A quote line can carry what it costs you, and its price can come from that cost. Open the line's **⋮ > Edit** and, under **Your cost**:

1. Type the **Cost each** - what one costs you.
2. Pick how it's priced under **Price by**: **Markup** adds a % to the cost, **Margin** makes the profit a % of the price, and **Set price** leaves the price as you type it. Markup 25% on a cost of 80.00 is 100.00; margin 25% on 80.00 is 106.67.
3. Type the **Percent**, or click one of the buttons under it. The **Price** is worked out as you go, and underneath it says what the line makes each.
4. Click **Save**.

![A quote line's Edit window, with its cost priced at a markup](bill-quote-line-cost.webp "Your cost: what one costs you, a markup or margin, and what the line makes")

Typing the **Price** yourself turns the line into a set price, and the window still shows its markup and margin. A line added from a product in the catalog takes the product's **Cost** and keeps its price.

While the quote can still be changed, each line with a cost shows it under its name, with its markup or margin, and the **Margin** beside the quote counts each line's own cost. Lines without a cost are left out of it - hover over it to see how many.

> [!NOTE]
> Only agents see costs. They're never on the PDF, the guest link, the client portal or the invoice made from the quote.

The markup or margin a new line starts with, and the buttons offered, are set in [Admin > Settings > Quotes](/admin/billing#quotes).

### Pictures {#pictures}

A line can show a picture beside its name - handy for hardware, so the client sees what they're getting. It's on the quote, the guest link, the client portal and the PDF.

![A quote line with a picture beside it](bill-quote-picture.webp "A line with its picture, as the client sees it")

To add one, open the line's **⋮ > Edit** and click the **Picture** box to open the **Picture** window. Drop, paste or choose a picture, then drag the corners and edges of the frame in to just the product, or click **Trim the edges** to cut away the plain background round it, and click **Use this picture** (see [Change a picture](/getting-started/account#picture)). Or paste a link instead - to a picture, or to the product's page on a supplier's website, and ITFlow takes the page's main picture. Click **Save**. To take it off, click the picture, then **Remove**, and save.

![The Picture field in a quote line's Edit window](bill-quote-line-picture.webp "Picture: click the box to add or crop one, or paste a link to a picture or a product page")

A product can keep a picture of its own, in its **Edit** window, and a line added from it takes a copy. Copying a quote copies its pictures too. ITFlow keeps its own smaller copy of each, so a picture still shows if the website it came from takes it down.

> [!NOTE]
> ITFlow only fetches pictures from public websites. A link to something on your own network won't work - save the picture and choose the file instead.

To leave pictures off quotes altogether, switch off **Show pictures on quotes** in [Admin > Settings > Quotes](/admin/billing#quotes).

With AI set up, **Write it with AI** under the lines drafts them from a sentence such as "three new laptops for the new starters, set up and joined to the domain". It uses your catalog's prices and the client's rate, and you check the lines before adding them. See [Using AI](/getting-started/ai).

> [!TIP]
> Quoting from a ticket? On a billable ticket, use **⋮ > Create quote**. The quote is linked to the ticket, and when it's invoiced the ticket goes on the same invoice.

## Send it

Click **Send**. Pick who it goes to, add a message if you like, and choose whether to **Attach the PDF**. The email has a link to view it, accept or decline it, and download it. To send it to someone who isn't one of the client's contacts, type their address in **Also send to** - it isn't saved.

![The Send Quote window](bill-quote-send.webp "Send Quote: who it goes to, an address that isn't a contact, a message of your own, and the PDF")

The arrow beside **Send** has **Quick Send**, which sends it straight to the client's primary contact, and **Mark Sent**, for a quote you gave the client some other way - it stops being a draft and its link works.

> [!NOTE]
> **Send** needs your outgoing mail set up. A client without a primary, billing, technical or important contact with an email address can still be sent one, to an address typed in **Also send to** - or use **Mark Sent**.

## What the client sees

The link opens the quote with **Accept** and **Decline** buttons, how long it's good for, and **Download PDF**. Clients who use the [client portal](/portal/billing) see it there too.

![The quote as the client sees it](bill-quote-guest.webp "The client's view: the quote, how long it's good for, and Accept or Decline")

When they answer, you get a notification, and an email goes to the address your admin set for quote answers. The quote's **History** shows who answered, by name, and any note they left - a PO number, when to start. In the portal, a client can also send you a signed copy or a purchase order - it shows on the quote under **From the client**.

If they say yes by phone or email instead, use **Accepted** or **Declined** at the top of the quote yourself. Either way, its lines are locked.

### When a quote expires

Three days before a sent quote runs out with no answer, everyone who can see quotes gets a [notification](/getting-started/notifications) to follow it up. It opens the quote.

An expired quote can't be accepted online - the client can still see it. A banner on it says when it ran out: to give the client more time, click **Extend** and set a new **Valid until** date. If they've said yes another way, **Accepted** still works.

![An expired quote, with Extend in the banner under it](bill-quote-expired.webp "An expired quote: extend it, or record the client's answer")

## Turn it into an invoice

Once a quote is accepted, click **Make Invoice** - or **Start Billing**, when it has monthly, quarterly or yearly lines.

![Start Billing for a quote with one-time and monthly lines](bill-quote-start.webp "Start Billing: what's billed once goes on an invoice, the rest on a recurring invoice")

- What's billed once goes on a **draft invoice** with the quote's discount and notes. Set its **Invoice date**; it's due on the client's terms.
- Each kind of recurring line - monthly, quarterly, yearly - goes on **a new recurring invoice**, or is added to one the client already has. For a new one, pick the **First invoice** date and whether **Its invoices** are **Emailed as they are made** or **Left as drafts to check**.
- **Bill the first month on the invoice now** puts the first period on the invoice as well, for clients who pay their first month up front. Start the recurring invoice a period later, so it isn't billed twice.

The quote is marked **Invoiced**, with a link to what it became. The invoice is a draft, so you can check it before you [send it](/billing/invoices#send-an-invoice).

## Other things you can do

The **⋮** menu on a quote has:

- **Download PDF** and **Print**
- **Copy Client Link** and **View as Client** - the client's link, and how it looks to them
- **Copy** - a new draft with the same lines, for this client or another
- **Mark Invoiced** - for a quote billed some other way. It's marked invoiced without making an invoice.
- **Delete** - it goes for good, with its lines and history

Your admin sets the quote numbering, the footer printed on every quote and where answers are emailed, in **Admin > Settings > Quotes**.
