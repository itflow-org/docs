---
title: Billing and expenses
description: API reference for invoices and their lines, quotes, products, taxes and expenses.
---

These endpoints need the **Sales** area of the key's role, apart from expenses, which need **Financial**. See [Keys and permissions](/api/permissions).

## Invoices {#invoices}

| Endpoint | Does |
|---|---|
| GET `invoices/read.php` | Lists invoices, or gets one |

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

Invoices are read only. Payments can't be read through the API.

## Invoice lines {#invoice-items}

| Endpoint | Does |
|---|---|
| GET `invoice_items/read.php` | An invoice's lines, or one line |
| POST `invoice_items/create.php` | Adds a line to an invoice |

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

## Quotes {#quotes}

| Endpoint | Does |
|---|---|
| GET `quotes/read.php` | Lists quotes, or gets one |

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

## Products {#products}

| Endpoint | Does |
|---|---|
| GET `products/read.php` | Lists your products and services, or gets one |

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
