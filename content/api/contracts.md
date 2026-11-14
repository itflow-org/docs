---
title: Contracts
description: API reference for contracts - making and changing them, activating, renewing and cancelling, sending them to sign, prepaid hours, and the recurring invoice that bills them.
---

These endpoints need the **Sales** area of the key's role, as [contracts](/billing/contracts) do in ITFlow: **Read** to list them, **Modify** to change them, and **Full** to delete one or a block of hours. See [Keys and permissions](/api/permissions).

| Endpoint | Does |
|---|---|
| GET `contracts/read.php` | Lists contracts, or gets one with its hours and signing |
| POST `contracts/create.php` | Adds a contract |
| POST `contracts/update.php` | Changes a contract |
| POST `contracts/activate.php` | Makes a draft active |
| POST `contracts/renew.php` | Renews a contract to a new last day |
| POST `contracts/cancel.php` | Cancels an active contract |
| POST `contracts/delete.php` | Deletes a contract |
| POST `contracts/send.php` | Sends it to be signed, or the link again |
| POST `contracts/withdraw.php` | Withdraws a signing request |
| POST `contract_hours/create.php` | Adds prepaid hours |
| POST `contract_hours/delete.php` | Deletes a block of hours nothing was drawn from |
| POST `contracts/draw.php` | Draws done tickets' time on the prepaid hours |
| POST `contracts/put_back.php` | Puts a ticket's hours back |
| POST `contracts/recurring.php` | Makes or links the recurring invoice that bills it |
| POST `contracts/unlink.php` | Unlinks that recurring invoice |

## Read {#contracts-read}

| Parameter | Does |
|---|---|
| `contract_id` | Just this contract, with its `hours` and `signature` |
| `client_id` | Just this client's |
| `limit`, `offset` | [Paging](/api/requests#paging) |

`contract_status` is `Draft`, `Active`, `Ended` or `Cancelled`. With `contract_id`, `hours` is its [prepaid hours](/billing/prepaid-hours) - `bought`, `used`, `left`, `lapsed`, `next_expiry` and each of its `blocks` - and `signature` its latest [signing request](/billing/contract-signing): its `contract_signature_id`, `state` - `sent` or `viewed` while it waits on the client, `countersign` once they signed, `signed` by both, or `withdrawn` - and who it went to.

**Fields:** `contract_id`, `contract_name`, `contract_status`, `contract_type`, `contract_details`, `contract_client_id`, `contract_rate_standard`, `contract_rate_after_hours`, `contract_net_terms`, `contract_support_hours`, `contract_start_date`, `contract_end_date`, `contract_created_at`, `contract_updated_at`, `contract_archived_at`, `contract_term_months`, `contract_auto_renew`, `contract_notice_days`, `contract_sla_low_id`, `contract_sla_medium_id`, `contract_sla_high_id`, `contract_sla_urgent_id`, `contract_template_id`, `contract_contact_id`, `contract_owner_id`, `contract_notes`, `contract_renewed_at`, `contract_reminded_at`, `contract_cancelled_at`, `contract_cancel_reason`, `contract_created_by`, `contract_monthly_hours`, `contract_hours_alert`, `contract_hours_alerted_at`, `contract_recurring_invoice_id`, `contract_recurring_stopped_at`.

## Create and update {#contracts-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `contract_name` | Required |
| `contract_type` | `managed` (the default), `comanaged`, `block`, `time_materials`, `break_fix`, `project` or `other` |
| `contract_status` | Create only: `Draft` (the default) or `Active` |
| `contract_start_date`, `contract_end_date` | As `2026-12-01` |
| `contract_term_months`, `contract_auto_renew`, `contract_notice_days` | Its term, whether it renews by itself, and the notice to cancel |
| `contract_contact_id`, `contract_owner_id` | The client's contact, and your agent who owns it |
| `contract_template_id` | A [contract template](/admin/contract-templates) |
| `contract_details`, `contract_notes` | |
| `contract_net_terms`, `contract_rate_standard`, `contract_rate_after_hours`, `contract_support_hours` | Empty rates are the default ones |
| `contract_sla_low_id`, `contract_sla_medium_id`, `contract_sla_high_id`, `contract_sla_urgent_id` | The SLA for each priority |
| `contract_monthly_hours`, `contract_hours_alert` | Hours included each month, and how few left to be told at |

Update takes `contract_id` and changes only what you send. A contract stays with its client and in its status - those change through the calls below. One out for signature whose wording changes has that request withdrawn; the answer's `withdrawn` is `1` then.

## Activate, renew, cancel and delete {#contracts-activate}

Each takes `contract_id` and `client_id`.

- **Activate** takes `start_date`, the day a draft is in force from.
- **Renew** takes `end_date`, its new last day - after its current one, and not in the past.
- **Cancel** takes `last_day`, the day it's in force until, and a `reason`. A signing request still out is withdrawn.
- **Delete** needs **Full**. Not once tickets drew on its prepaid hours, or it was signed by both sides.

Activate, renew and cancel start or stop its recurring invoice to match - the answer's `recurring` says which.

## Signing {#contracts-send}

**Send** takes `contract_id`, `client_id`, and `contact_id` - one of the client's contacts with an email address - or `to_name` and `to_email`, with a `note` for the email. They get a link to read and sign it. With `contract_signature_id`, the link of a request still waiting goes again instead. The answer has `contract_signature_id`, and `emailed` - `0` when ITFlow doesn't send mail, and the link is then on the contract's page to send yourself.

**Withdraw** takes `contract_id`, `client_id` and `contract_signature_id`, and the link no longer signs anything.

Countersigning is done in ITFlow.

## Prepaid hours {#contract-hours}

**Add hours** (`contract_hours/create.php`) takes `contract_id`, `client_id`, `hours` and `bought` (the day they were bought), both required, and `expires`, `price`, `note`, and `invoice` - `1` makes a draft invoice for them, in the income `category` you name. They go on a draft or active contract, or a cancelled one until its last day. The answer has `invoice_id` and `invoice_reference` when an invoice was made.

**Delete hours** (`contract_hours/delete.php`) takes `contract_block_id` - from the contract's `hours` - and `client_id`. Time drawn from them keeps them; an invoice made for them stays.

**Draw** (`contracts/draw.php`) takes `contract_id` and `client_id`, and draws the time on the client's done tickets waiting to bill from its prepaid hours now - or just `ticket_id`'s. The nightly run does it too. The answer has `tickets`, `hours`, what's `left`, and `overage` - hours over what was left, still to bill.

**Put back** (`contracts/put_back.php`) takes `contract_id`, `client_id` and `ticket_id`, and the ticket's time is to bill as usual again - not once it's on an invoice. The answer has `hours`.

## The recurring invoice {#contracts-recurring}

**Recurring** (`contracts/recurring.php`) takes `contract_id`, `client_id`, and `recurring_invoice_id` - one of the client's that isn't another contract's - to link, or the fields of a new one to make: `item_name` and `amount`, both required, and `frequency` (`month`, the default, `quarter` or `year`), `start` (its first invoice), `description`, `tax_id`, `category` and `auto_send`. It runs while the contract is in force. The answer has `recurring_invoice_id`, `reference` and `state`.

**Unlink** (`contracts/unlink.php`) takes `contract_id` and `client_id`. The recurring invoice carries on as it is, running or paused.
