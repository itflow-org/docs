---
title: Billing and expenses
description: API reference for invoices and their lines, recurring invoices, quotes, products, taxes and expenses.
---

These endpoints need the **Sales** area of the key's role, apart from expenses, which need **Financial**. Making and changing needs **Modify**, and deleting **Full**. See [Keys and permissions](/api/permissions).

## Invoices {#invoices}

| Endpoint | Does |
|---|---|
| GET `invoices/read.php` | Lists invoices, or gets one |
| POST `invoices/create.php` | Makes a draft invoice, with its lines |
| POST `invoices/update.php` | Changes an invoice's dates, scope, category, discount or note |
| POST `invoices/send.php` | Emails an invoice, or a reminder of what is owed on it |
| POST `invoices/mark_sent.php` | Marks an invoice sent without emailing it |
| POST `invoices/cancel.php` | Cancels an invoice |
| POST `invoices/delete.php` | Deletes an invoice |

### Read {#invoices-read}

| Parameter | Does |
|---|---|
| `invoice_id` | Just this invoice |
| `client_id` | Just this client's invoices |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Every invoice is listed, whatever its status. `invoice_amount` is its total. ITFlow works out the rest of the sums and adds them to each invoice:

| Field | Notes |
|---|---|
| `invoice_subtotal` | The total before tax |
| `invoice_tax` | The tax |
| `invoice_taxes` | The tax by each part of it, as on the invoice: a `name` and an `amount` |
| `invoice_tax_registrations` | The tax registration lines printed on the invoice |

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "invoice_id": "475",
      "invoice_prefix": "INV-",
      "invoice_number": "475",
      "invoice_scope": "Wireless upgrade - two access points for the treatment rooms",
      "invoice_status": "Draft",
      "invoice_date": "2026-10-21",
      "invoice_due": "2026-11-05",
      "invoice_amount": "824.30",
      "invoice_currency_code": "USD",
      "invoice_client_id": "1",
      "invoice_subtotal": 790,
      "invoice_tax": 34.3,
      "invoice_taxes": [ { "name": "PA Sales Tax 6%", "amount": 29.4 }, { "name": "Allegheny County 1%", "amount": 4.9 } ],
      "invoice_tax_registrations": [ "Allegheny County Sales Tax No. 75520193" ]
    }
  ]
}
```

**Fields:** `invoice_id`, `invoice_prefix`, `invoice_number`, `invoice_scope`, `invoice_status`, `invoice_date`, `invoice_due`, `invoice_discount_amount`, `invoice_credit_amount`, `invoice_amount`, `invoice_currency_code`, `invoice_note`, `invoice_url_key`, `invoice_category_id`, `invoice_recurring_invoice_id`, `invoice_quote_id`, `invoice_client_id`, `invoice_created_at`, `invoice_updated_at`, `invoice_archived_at`, and the sums above.

Payments can't be read through the API.

### Create {#invoices-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `date` | Its date, as `2026-11-05`. Today if you leave it out. It's due on the client's terms from then. |
| `scope` | What it's for |
| `category_id` | An income [category](/api/lookups#categories) |
| `discount` | An amount off it |
| `note` | The note it carries |
| `items` | Its lines, up to 100. Each is a `product_id` - its name, description and price unless you send them - or a `name` and `price`; with `qty` (1 if left out), `description`, and `tax_id`: a tax's id, or `default` for the client's usual rate. A product whose stock is tracked has to have enough on the shelf. |

It's made as New Invoice makes one - the next number, in your company's currency - and stays a draft until it's sent. A client, date or line that won't do is refused with `400` and why in `message`.

```
curl -X POST https://itflow.example.com/api/v1/invoices/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "scope": "Wireless upgrade", "items": [{"product_id": 96, "qty": 2, "tax_id": "default"}, {"name": "Installation", "price": 150}]}'
```

```json
{
  "success": "True", "count": "1", "data": [ { "insert_id": 476 } ],
  "invoice_reference": "INV-476", "amount": 824.30,
  "url": "https://itflow.example.com/guest/guest_view_invoice.php?invoice_id=476&url_key=..."
}
```

`url` is where the client views and pays it, once it's sent.

### Update {#invoices-update}

`update.php` takes `invoice_id`, `client_id` - the invoice's own client - and any of `date`, `due` (both as `2026-11-05`), `scope`, `category_id`, `discount` and `note`. Only what you send changes, and the total follows the discount. Its lines change through [Invoice lines](#invoice-items).

### Send {#invoices-send}

| Field | Notes |
|---|---|
| `invoice_id` | Required |
| `client_id` | The invoice's client. Needed when the key's agent can see only some clients. |
| `contact_ids` | The client's contacts to email, as a list. Left out, its primary and billing contacts. |
| `kind` | `invoice`, the default, or `reminder` - a reminder of what is still owed on one already sent |
| `note` | A note at the top of the email |
| `attach_pdf` | `1` to attach the PDF, `0` not to. Left out, as [Invoices and billing](/admin/billing#reminders-and-statements) is set. |

It goes as Send does in ITFlow, from your billing address, with the invoice's link to view and pay it. A draft becomes Sent; anything further along keeps its status. Those of the contacts who agreed to texts get its link by text too, when [text messaging](/admin/text-messaging) is set up. A cancelled or non-billable invoice isn't sent.

```json
{
  "success": "True", "count": 1,
  "emailed_to": ["Priya Raghavan (praghavan@ravenwooddental.example)", "Dana Prescott (dprescott@ravenwooddental.example)"],
  "status": "Sent",
  "url": "https://itflow.example.com/guest/guest_view_invoice.php?invoice_id=476&url_key=..."
}
```

### Mark sent, cancel and delete {#invoices-cancel}

Each takes `invoice_id` and `client_id`, the invoice's own client.

- **Mark sent** takes `sent_method` - `Sent by Snail Mail`, `Sent by Email Client`, `Hand Delivered`, `Sent by Fax`, `Sent by Courier`, `Shared Guest Link` or `Other` - and a `note` for its history. Nobody is emailed.
- **Cancel** marks it Cancelled. It stays, and what it took off the shelf goes back.
- **Delete** needs **Full** on Sales. Its lines, history and payments go with it, what it took off the shelf goes back, and the tickets, expenses and trips billed on it are to bill again. Once a payment on it has cleared on a [reconciled statement](/finance/reconciling), it can't be deleted - cancel it instead.

## Invoice lines {#invoice-items}

| Endpoint | Does |
|---|---|
| GET `invoice_items/read.php` | An invoice's lines, or one line |
| POST `invoice_items/create.php` | Adds a line to an invoice |
| POST `invoice_items/update.php` | Changes a line |
| POST `invoice_items/delete.php` | Takes a line off |

### Read {#invoice-items-read}

| Parameter | Does |
|---|---|
| `invoice_id` | This invoice's lines, in their order. You need this or `item_id`. |
| `item_id` | Just this line |
| `client_id` | Only if the invoice is this client's |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Each line comes with its tax rate's `tax_name` and `tax_percent`.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "item_id": "1956", "item_name": "Ubiquiti U6-Pro Access Point", "item_description": "Wi-Fi 6 access point, ceiling mounted", "item_quantity": "2.00", "item_price": "245.00", "item_subtotal": "490.00", "item_tax": "34.30", "item_total": "524.30", "item_order": "1", "item_tax_id": "2", "item_product_id": "96", "item_invoice_id": "475", "tax_name": "Allegheny County Sales Tax", "tax_percent": "7.0000" }
  ]
}
```

**Fields:** `item_id`, `item_name`, `item_description`, `item_quantity`, `item_price`, `item_subtotal`, `item_tax`, `item_total`, `item_order`, `item_tax_id`, `item_product_id`, `item_invoice_id`, `item_created_at`, `item_updated_at`, `item_archived_at`, `tax_name`, `tax_percent`.

### Create {#invoice-items-create}

| Field | Notes |
|---|---|
| `invoice_id` | Required. The invoice can't be paid already. |
| `name` | Required, up to 200 characters |
| `qty` | Required, more than 0 |
| `price` | The price of one |
| `description` | |
| `tax_id` | A [tax rate](#taxes)'s `tax_id`, `0` for no tax, or `default` for the rate the client - or the product - usually has |
| `product_id` | The [product](#products) it is. One whose stock is tracked has the quantity taken from stock, and the line is turned down if there isn't enough. |
| `item_order` | Where it goes among the lines |
| `client_id` | The invoice's client. Needed when the key's agent can see only some clients. |

The invoice's totals are worked out again afterwards.

```
curl -X POST https://itflow.example.com/api/v1/invoice_items/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "invoice_id": 475, "name": "Patch cables", "description": "Cat6, 3 ft", "qty": 4, "price": 6.50, "tax_id": "default"}'
```

### Update and delete {#invoice-items-update}

Both take `item_id` and `client_id`, the invoice's client. `update.php` takes any of `name`, `description`, `qty`, `price` and `tax_id`, and changes only what you send. `delete.php` needs **Full** on Sales. A tracked product's stock follows the line - more taken off the shelf, or put back. The invoice's totals are worked out again, and the lines of a paid, cancelled or non-billable invoice can't change.

## Recurring invoices {#recurring-invoices}

| Endpoint | Does |
|---|---|
| GET `recurring_invoices/read.php` | Lists recurring invoices, or gets one with its lines |
| POST `recurring_invoices/create.php` | Makes one, and its first invoice now if you ask |
| POST `recurring_invoices/update.php` | Changes one |
| POST `recurring_invoices/status.php` | Pauses or resumes one |
| POST `recurring_invoices/delete.php` | Deletes one |

### Read {#recurring-invoices-read}

| Parameter | Does |
|---|---|
| `recurring_invoice_id` | Just this one, with its lines as `items` |
| `client_id` | Just this client's |
| `limit`, `offset` | [Paging](/api/requests#paging) |

### Create {#recurring-invoices-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `items` | Required: its lines, 1 to 100. Each is a `product_id` - its name, description and price unless you send them - or a `name` and `price`; with `qty` (1 if left out), `description`, and `tax_id`: a tax's id, or `default` for the client's usual rate. |
| `frequency` | `month` (the default), `quarter` or `year` |
| `start_date` | Its first run, as `2026-11-05`. Today if you leave it out. |
| `scope` | What it's for, shown on each invoice |
| `note`, `category_id`, `discount` | The note each invoice carries, an income category, and an amount off each one |
| `auto_send` | `1`, the default: each invoice it makes is emailed by itself. `0` leaves them as drafts. |
| `invoice_now` | `1` makes the first invoice now, in place of the run on `start_date` - the next is a period later |
| `invoice_send` | With `invoice_now`, `1` (the default) emails it to the client's primary and billing contacts and marks it Sent, so it can be paid from its link. `0` leaves it a draft. |

It's made in the client's currency, as a recurring invoice in ITFlow is. A client, date, product or line that won't do is refused with `400` and why in `message`.

```
curl -X POST https://itflow.example.com/api/v1/recurring_invoices/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "scope": "Managed services", "items": [{"product_id": 4, "tax_id": "default"}, {"product_id": 5, "qty": 12, "tax_id": "default"}], "invoice_now": 1}'
```

```json
{
  "success": "True", "count": "1", "data": [ { "insert_id": 19 } ],
  "recurring_invoice_reference": "REC-19", "amount": 450, "next_date": "2026-12-05",
  "invoice": { "invoice_id": 469, "reference": "INV-469", "amount": 450, "currency": "USD", "due": "2026-12-05", "status": "Sent",
               "url": "https://itflow.example.com/guest/guest_view_invoice.php?invoice_id=469&url_key=...", "emailed_to": ["Priya Raghavan (praghavan@ravenwooddental.example)"] }
}
```

`invoice.url` is where the client views and pays it - put it behind a Pay button. To have a ticket wait for that invoice to be paid, raise it with `ticket_invoice_id` - see [Tickets](/api/tickets#tickets-create).

### Update, pause and delete {#recurring-invoices-update}

Each takes `recurring_invoice_id` and `client_id`, its own client.

- **Update** takes any of `frequency`, `next_date` (its next run, as `2026-11-05` - the day of the month it bills on moves with it), `scope`, `note`, `category_id`, `discount` and `auto_send`, and changes only what you send. Its lines change through [Recurring invoice lines](#recurring-invoice-items).
- **Status** takes `status`: `0` pauses it, `1` resumes it. Resumed with its next run already past, it won't run until `next_date` is moved on - the answer's `message` says so.
- **Delete** needs **Full** on Sales. Its lines, history and autopay go with it; the invoices it made stay.

## Recurring invoice lines {#recurring-invoice-items}

| Endpoint | Does |
|---|---|
| GET `recurring_invoice_items/read.php` | A recurring invoice's lines, or one line |
| POST `recurring_invoice_items/create.php` | Adds a line |
| POST `recurring_invoice_items/update.php` | Changes a line |
| POST `recurring_invoice_items/delete.php` | Takes a line off |

Read takes `recurring_invoice_id` or `item_id`, as [Invoice lines](#invoice-items-read) does. Create takes `recurring_invoice_id`, and a `product_id` - its name, description and price unless you send them - or a `name` and `price`, with `qty`, `description` and `tax_id`. Update and delete take `item_id`, and update changes only what you send; delete needs **Full** on Sales. Each takes `client_id`, the recurring invoice's client.

A line can count its quantity from the client, as Quantity from does in the line window:

| Field | Notes |
|---|---|
| `seat_source` | `contacts` (users), `assets` (devices), `managed` (the devices your [RMM](/admin/rmm) has) or `license` (a license's seats). An empty `seat_source` stops counting, and the line keeps its quantity. |
| `seat_tag` | Only those with this tag - users or devices |
| `seat_types` | Devices of these types only, as a list - such as `["Desktop", "Laptop"]` |
| `seat_rmm` | With `managed`, one RMM provider's devices |
| `seat_software_id`, `seat_count` | With `license`, the license, and `used` (the default) or `total` seats |
| `seat_minimum` | The least it bills, whatever the count |

## Quotes {#quotes}

| Endpoint | Does |
|---|---|
| GET `quotes/read.php` | Lists quotes, or gets one |
| POST `quotes/create.php` | Makes a draft quote, with its lines |
| POST `quotes/update.php` | Changes a quote's dates, scope, category, discount or note |
| POST `quotes/send.php` | Emails a quote |
| POST `quotes/mark_sent.php` | Marks a quote sent without emailing it |
| POST `quotes/accept.php` | Records that the client accepted |
| POST `quotes/decline.php` | Records that the client declined |
| POST `quotes/invoice.php` | Invoices an accepted quote |
| POST `quotes/delete.php` | Deletes a quote |

### Read {#quotes-read}

| Parameter | Does |
|---|---|
| `quote_id` | Just this quote |
| `client_id` | Just this client's quotes |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Like invoices, each quote comes with `quote_subtotal`, `quote_tax`, `quote_taxes` and `quote_tax_registrations`. On a quote with monthly lines, those are for the one-time part, and `quote_monthly_amount` is the monthly total.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "quote_id": "2", "quote_prefix": "QUO-", "quote_number": "2", "quote_scope": "Uninterruptible power supply for the comms rack", "quote_status": "Accepted", "quote_amount": "1312.95", "quote_monthly_amount": "0.00", "quote_subtotal": 1265, "quote_tax": 47.95, "quote_taxes": [ { "name": "PA Sales Tax 6%", "amount": 41.1 }, { "name": "Allegheny County 1%", "amount": 6.85 } ] }
  ]
}
```

**Fields:** `quote_id`, `quote_prefix`, `quote_number`, `quote_scope`, `quote_status`, `quote_discount_amount`, `quote_date`, `quote_expire`, `quote_amount`, `quote_monthly_amount`, `quote_currency_code`, `quote_note`, `quote_url_key`, `quote_category_id`, `quote_client_id`, `quote_created_at`, `quote_updated_at`, `quote_archived_at`, and the sums above.

### Create {#quotes-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `date` | Its date, as `2026-11-05`. Today if you leave it out. |
| `expire` | The day it runs out. 30 days on if you leave it out. |
| `scope`, `category_id`, `discount`, `note` | As for [invoices](#invoices-create) |
| `items` | Its lines, up to 100, as for [invoices](#invoices-create) - each also with `frequency`: billed once if you leave it out, or `month`, `quarter` or `year` |

It's made as New Quote makes one, and stays a draft until it's sent. The answer has `quote_reference`, `amount` and `url`, where the client views it and accepts or declines.

```
curl -X POST https://itflow.example.com/api/v1/quotes/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "scope": "Managed workstations", "items": [{"name": "Onboarding", "price": 500}, {"product_id": 1, "qty": 12, "frequency": "month", "tax_id": "default"}]}'
```

### Update, send and mark sent {#quotes-update}

Each takes `quote_id` and `client_id`, the quote's own client.

- **Update** takes any of `date`, `expire`, `scope`, `category_id`, `discount` and `note`, and changes only what you send. Its lines change through [Quote lines](#quote-items).
- **Send** takes `contact_ids` - the client's primary contact if you leave it out - `note` and `attach_pdf`, as [Send](#invoices-send) does for an invoice. A draft becomes Sent. The answer has `emailed_to`, `status` and `url`.
- **Mark sent** takes `sent_method` and `note`, as for [invoices](#invoices-cancel).

### Accept, decline and invoice {#quotes-accept}

**Accept** and **Decline** take `quote_id` and `client_id`, and record the client's answer as the buttons on the quote's page do. A quote that's been invoiced keeps its answer.

**Invoice** turns an accepted quote into invoices, as Invoice does on its page. Its one-time lines go on a new draft invoice, and its lines billed each month, quarter or year on a recurring invoice for each.

| Field | Notes |
|---|---|
| `quote_id` | Required |
| `client_id` | The quote's client. Needed when the key's agent can see only some clients. |
| `date` | The invoice's date. Today if you leave it out. |
| `first_period` | `1` puts the recurring lines on the invoice too, billing their first period now |
| `recurring` | Where each frequency's lines go: `{"month": {"to": 0, "start": "2026-12-01", "auto_send": 1}}`. `to` is `0` for a new recurring invoice - the default - or one of the client's billed as often. `start` is a new one's first run, the first of next month if you leave it out. `auto_send` `1`, the default, emails its invoices; `0` leaves them drafts. |

The quote becomes Invoiced. The answer has `invoice_id` - `0` when there were no one-time lines - `recurring_invoice_ids`, and `references`, such as `["INV-477", "REC-20"]`.

### Delete {#quotes-delete}

`delete.php` takes `quote_id` and `client_id`, and needs **Full** on Sales. Its lines and history go with it, and invoices made from it no longer point at it.

## Quote lines {#quote-items}

| Endpoint | Does |
|---|---|
| GET `quote_items/read.php` | A quote's lines, or one line |
| POST `quote_items/create.php` | Adds a line |
| POST `quote_items/update.php` | Changes a line |
| POST `quote_items/delete.php` | Takes a line off |

They work as [Invoice lines](#invoice-items) do, with `quote_id` in place of `invoice_id`, and each line's `frequency`: billed once if you leave it out, or `month`, `quarter` or `year`. A quote that's been accepted, declined or invoiced keeps its lines.

## Products {#products}

| Endpoint | Does |
|---|---|
| GET `products/read.php` | Lists your products and services, or gets one |
| POST `products/create.php` | Adds a product or service |
| POST `products/update.php` | Changes one |
| POST `products/archive.php` | Archives one - it's no longer offered on new lines |
| POST `products/unarchive.php` | Brings an archived one back |
| POST `products/delete.php` | Deletes an archived one |

### Read {#products-read}

| Parameter | Does |
|---|---|
| `product_id` | Just this product |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Products aren't a client's, so `client_id` doesn't apply. The list includes archived products.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "product_id": "1", "product_name": "Managed Workstation", "product_type": "service", "product_code": "MS-WKS", "product_price": "65.00", "product_currency_code": "USD", "product_frequency": "month", "product_track_stock": "0", "product_tax_id": "0", "product_category_id": "15" }
  ]
}
```

**Fields:** `product_id`, `product_name`, `product_type`, `product_description`, `product_notes`, `product_code`, `product_vendor_part`, `product_location`, `product_price`, `product_cost`, `product_currency_code`, `product_frequency`, `product_seat_source`, `product_track_stock`, `product_reorder_level`, `product_reorder_qty`, `product_asset_type`, `product_make`, `product_model`, `product_warranty_months`, `product_tax_id`, `product_category_id`, `product_vendor_id`, `product_created_at`, `product_updated_at`, `product_archived_at`.

### Create and update {#products-create}

`create.php` and `update.php` take the fields above - apart from the ids and dates, and `product_currency_code`, which is your company's. `product_name` is needed to create one; `update.php` takes `product_id` and changes only what you send.

| Field | Notes |
|---|---|
| `product_type` | `service`, the default, or `product` |
| `product_price`, `product_cost` | |
| `product_frequency` | How it's billed: once if empty, or `month`, `quarter` or `year` |
| `product_seat_source` | On a recurring invoice, its quantity from the client: `contacts` (per user), `assets` (per device) or `managed` (per managed device) |
| `product_track_stock` | `1` to keep count of its stock |

They're checked as the product window checks them, and a value that won't do is refused with `400` and why in `message`. Products aren't a client's, so a key whose agent can see only some clients can't change them.

### Archive, unarchive and delete {#products-archive}

Each takes `product_id`. `delete.php` needs **Full** on Sales, and the product has to be archived first. Its stock and price history go with it; lines it's on keep their text and amounts.

## Taxes {#taxes}

| Endpoint | Does |
|---|---|
| GET `taxes/read.php` | Lists your tax rates, or gets one |

| Parameter | Does |
|---|---|
| `tax_id` | Just this rate, archived or not |
| `archived` | `1` to include archived rates |
| `limit`, `offset` | [Paging](/api/requests#paging) |

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "tax_id": 2,
      "tax_name": "Allegheny County Sales Tax",
      "tax_percent": 7,
      "tax_description": "Pennsylvania 6% plus the Allegheny County local 1%",
      "tax_registration_number": "75520193",
      "tax_archived_at": null,
      "tax_replaced_by": 0,
      "tax_default": false,
      "tax_components": [
        { "name": "PA Sales Tax", "percent": 6, "compound": false, "registration_number": "75520193" },
        { "name": "Allegheny County", "percent": 1, "compound": false, "registration_number": "75520193" }
      ]
    }
  ]
}
```

`tax_percent` is the whole rate, and `tax_components` its parts. A part that's `compound` is charged on top of the parts before it. `tax_default` is `true` for the rate new lines get, and `tax_replaced_by` is the rate that replaced a changed one. See [Taxes](/admin/taxes).

## Expenses {#expenses}

| Endpoint | Does |
|---|---|
| GET `expenses/read.php` | Lists expenses, or gets one |
| POST `expenses/create.php` | Records an expense, or money back on one |
| POST `expenses/update.php` | Changes an expense |
| POST `expenses/delete.php` | Deletes an expense |

### Read {#expenses-read}

| Parameter | Does |
|---|---|
| `expense_id` | Just this expense |
| `client_id` | Just this client's expenses. `0` for those that aren't a client's. |
| `limit`, `offset` | [Paging](/api/requests#paging) |

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "expense_id": "13", "expense_description": "Hardware supplied to Ravenwood Dental Group", "expense_amount": "1762.00", "expense_date": "2026-10-14", "expense_vendor_id": "1", "expense_category_id": "76", "expense_client_id": "1", "expense_billable": "1", "expense_invoice_id": null }
  ]
}
```

**Fields:** `expense_id`, `expense_description`, `expense_amount`, `expense_tax_id`, `expense_tax_amount`, `expense_currency_code`, `expense_date`, `expense_reference`, `expense_payment_method`, `expense_receipt`, `expense_vendor_id`, `expense_client_id`, `expense_category_id`, `expense_account_id`, `expense_refund_of_id`, `expense_recurring_expense_id`, `expense_billable`, `expense_markup`, `expense_invoice_id`, `expense_invoice_item_id`, `expense_import_key`, `expense_paid_by`, `expense_reimbursement_id`, `expense_reconciliation_id`, `expense_created_by`, `expense_created_at`, `expense_updated_at`, `expense_archived_at`.

### Create {#expenses-create}

| Field | Notes |
|---|---|
| `expense_date` | Required: the day it was paid, as `2026-11-05` |
| `expense_amount` | Required |
| `expense_vendor_id` | Required: one of your [vendors](/api/clients#vendors) |
| `expense_category_id` | Required: an expense [category](/api/lookups#categories) |
| `expense_account_id` | Required: the account it was paid from - or `personal`, with `expense_paid_by`, the agent who paid it and is to be paid back |
| `client_id` | The client it was for. Leave it out for overhead. |
| `expense_description`, `expense_reference` | |
| `expense_payment_method` | One of your [payment methods](/admin/billing#payment-methods) |
| `expense_tax_id`, `expense_tax_amount` | The tax included in it. With a rate and no amount, the amount is worked out. |
| `expense_billable`, `expense_markup` | `1` to bill it on to the client, at a markup percent |
| `expense_refund_of_id` | Records money back on that expense, as Refund does |

It's checked as the expense window checks it - an amount, one of your vendors, categories and accounts - and a value that won't do is refused with `400` and why in `message`. A receipt is added in ITFlow.

```
curl -X POST https://itflow.example.com/api/v1/expenses/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "expense_date": "2026-11-10", "expense_amount": "189.00", "expense_vendor_id": 1, "expense_category_id": 76, "expense_account_id": 1, "expense_description": "Replacement switch", "expense_billable": 1}'
```

### Update and delete {#expenses-update}

Both take `expense_id` and `client_id`, the expense's client - `0` for overhead. `update.php` also takes any of the fields under [Create](#expenses-create), and changes only what you send - its tax stays unless you send `expense_tax_id` or `expense_tax_amount`. `expense_client_id` moves it to another client, or to overhead with `0`. `delete.php` needs **Full** on Financial, and its receipt goes with it.

The out side of a transfer, money paid back to an agent, and an expense cleared on a [reconciled statement](/finance/reconciling) can't be changed or deleted here - as in ITFlow.
