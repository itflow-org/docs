---
title: Accounts and money
description: API reference for accounts and their balances, other income, transfers between accounts, and recurring expenses.
---

These endpoints need the **Financial** area of the key's role: **Read** to list, **Modify** to record and change, and **Full** to delete. See [Keys and permissions](/api/permissions). Payments on invoices and expenses are under [Billing and expenses](/api/billing).

Accounts and transfers are your business's own, not a client's, so a key whose agent can see only some clients can't change them.

A line that has cleared on a [reconciled statement](/finance/reconciling) keeps its date, amount and account, and can't be deleted - undo that reconciliation first.

## Accounts {#accounts}

| Endpoint | Does |
|---|---|
| GET `accounts/read.php` | Lists your accounts with their balances, or gets one |
| POST `accounts/create.php` | Adds an account |
| POST `accounts/update.php` | Changes an account |
| POST `accounts/archive.php` | Archives an account |
| POST `accounts/unarchive.php` | Brings an archived account back |
| POST `accounts/delete.php` | Deletes an account nothing has been on |

Read takes `account_id` (archived or not) and `archived` - `1` to include archived accounts. Each has its `balance` today: the opening balance with every payment, income, expense and transfer on it.

```json
{ "success": "True", "count": 1, "data": [ { "account_id": 2, "account_name": "Operating Checking", "account_type": 1, "account_currency_code": "USD", "opening_balance": 18500, "balance": 41237.5, "account_description": null, "account_notes": null, "account_created_at": "2024-11-01 09:00:00", "account_archived_at": null } ] }
```

| Field | Notes |
|---|---|
| `account_name` | Required, and no other account can have it |
| `account_type` | Required: `1` Checking, `2` Savings, `3` Credit card, `4` Cash, `5` Payment processor or `6` Other |
| `account_currency_code` | Such as `USD`. Your company's if you leave it out. It stays once money is on the account. |
| `opening_balance` | What was in it when you started. Owed on a card is below 0. |
| `account_description`, `account_notes` | |

Update takes `account_id` and changes only what you send. **Archive** needs the account empty, and not the one online payments go into. **Delete** needs **Full**, and only an account nothing has ever been on can be deleted - archive one with history instead. See [Accounts](/finance/accounts).

## Other income {#revenues}

Money in that isn't a payment on an invoice - a referral fee, interest, a refund from a supplier. See [Other income](/finance/income).

| Endpoint | Does |
|---|---|
| GET `revenues/read.php` | Lists other income, or gets one |
| POST `revenues/create.php` | Records other income |
| POST `revenues/update.php` | Changes it |
| POST `revenues/delete.php` | Deletes it |

Read takes `revenue_id` and `client_id` (`0` for income of no client), with `limit` and `offset`. Each has its `category_name`, `account_name` and `client_name`. The in side of a transfer isn't listed.

| Field | Notes |
|---|---|
| `revenue_date` | Required, as `2026-11-05` |
| `revenue_amount` | Required |
| `revenue_account_id` | Required: the [account](#accounts) it went into. It's in the account's currency. |
| `revenue_category_id` | Required: an income [category](/api/lookups#categories) |
| `revenue_client_id` | The client it came from |
| `revenue_payment_method`, `revenue_reference`, `revenue_description` | |

Update and delete take `revenue_id` and `client_id`, its client. Update changes only what you send.

## Transfers {#transfers}

Money moved between two of your accounts - paying off a card, sweeping to savings, a processor's payout.

| Endpoint | Does |
|---|---|
| GET `transfers/read.php` | Lists transfers, or gets one |
| POST `transfers/create.php` | Moves money between accounts |
| POST `transfers/update.php` | Changes a transfer |
| POST `transfers/delete.php` | Deletes a transfer |

Read takes `transfer_id` and `account_id` - those out of or into it - with `limit` and `offset`. Each has `transfer_date`, `transfer_amount`, both accounts' ids and names, `transfer_method` and `transfer_notes`.

Create takes `transfer_date`, `transfer_amount`, `transfer_from_account_id` and `transfer_to_account_id` - two different accounts - all required, and `transfer_method` (one of your payment methods) and `transfer_notes`. Update takes `transfer_id` and changes only what you send. Delete takes `transfer_id`, and both its sides go.

```json
{ "api_key": "YOUR_API_KEY", "transfer_date": "2026-11-12", "transfer_amount": "4250.00", "transfer_from_account_id": 4, "transfer_to_account_id": 2, "transfer_notes": "Card settlements paid out" }
```

## Recurring expenses {#recurring-expenses}

Bills that come round - hosting each month, a domain each year - recorded as an [expense](/api/billing#expenses) on each date by the nightly run. See [Recurring expenses](/finance/recurring-expenses).

| Endpoint | Does |
|---|---|
| GET `recurring_expenses/read.php` | Lists recurring expenses, or gets one |
| POST `recurring_expenses/create.php` | Sets one up |
| POST `recurring_expenses/update.php` | Changes one |
| POST `recurring_expenses/status.php` | Pauses or resumes one |
| POST `recurring_expenses/record.php` | Records its next run now |
| POST `recurring_expenses/move_on.php` | Skips the runs it missed |
| POST `recurring_expenses/delete.php` | Deletes one |

Read takes `recurring_expense_id` and `client_id` (`0` for the business's own), with `limit` and `offset`, soonest first. `recurring_expense_status` is `1` while it runs and `0` once paused or ended.

| Field | Notes |
|---|---|
| `recurring_expense_vendor_id` | Required: one of your [vendors](/api/clients#vendors) |
| `recurring_expense_amount` | Required: each time |
| `recurring_expense_frequency` | Required: `month`, `quarter` or `year` |
| `recurring_expense_next_date` | Required: the first one, as `2026-12-01`. A moved date is the day it keeps to from then. |
| `recurring_expense_account_id` | Required: the account it's paid from |
| `recurring_expense_category_id` | Required: an expense category |
| `recurring_expense_end_date` | The last day it runs |
| `recurring_expense_client_id` | The client it's for |
| `recurring_expense_billing` | `bill` - to the client, at `recurring_expense_markup` percent - `covered` by the client's recurring invoice `recurring_expense_recurring_invoice_id`, or `none` |
| `recurring_expense_tax_id`, `recurring_expense_tax_amount` | The tax in it. Left out on an update, it keeps its own. |
| `recurring_expense_payment_method`, `recurring_expense_reference`, `recurring_expense_description` | |

Each of the others takes `recurring_expense_id` and `client_id`, its client.

- **Update** changes only what you send.
- **Status** takes `status`: `0` pauses it, `1` resumes it. One that has ended runs again only once its end date is moved. Resumed with its next date long past, the answer's `message` says to record the missed runs or move it on.
- **Record** records its next run now, as **Record Now** does - or the one on the day `run` names, which is recorded once however often it's asked for. The answer has `expense_id`, and `next_date` - `null` once it has ended.
- **Move on** skips the runs it missed without recording them. The answer has `next_date`.
- **Delete** needs **Full**. The expenses it recorded stay.
