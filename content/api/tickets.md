---
title: Tickets
description: API reference for tickets, ticket replies and technicians - raising, updating, replying to, resolving and closing tickets, and the time worked on them.
---

These endpoints need the **Support** area of the key's role. See [Keys and permissions](/api/permissions).

## Tickets {#tickets}

| Endpoint | Does |
|---|---|
| GET `tickets/read.php` | Lists tickets, or gets one |
| POST `tickets/create.php` | Raises a ticket |
| POST `tickets/update.php` | Changes a ticket |
| POST `tickets/resolve.php` | Resolves a ticket |
| POST `tickets/close.php` | Closes a ticket |

Tickets can't be deleted through the API.

### Read {#tickets-read}

| Parameter | Does |
|---|---|
| `ticket_id` | Just this ticket, with its status's name and colour |
| `client_id` | Just this client's tickets |
| `limit`, `offset` | [Paging](/api/requests#paging) |

The list has every ticket - new, open, resolved and closed. `ticket_status` is the status's number: 1 New, 2 Open, 3 On Hold, 4 Resolved and 5 Closed, then any you've added in [Admin > Ticket Statuses](/admin/tickets#ticket-statuses).

```
curl -G https://itflow.example.com/api/v1/tickets/read.php \
  --data-urlencode "api_key=YOUR_API_KEY" \
  --data-urlencode "ticket_id=93"
```

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "ticket_id": "93",
      "ticket_prefix": "TCK-",
      "ticket_number": "93",
      "ticket_source": "Email",
      "ticket_subject": "Site internet dropping intermittently",
      "ticket_priority": "High",
      "ticket_status": "2",
      "ticket_status_name": "Open",
      "ticket_billable": "1",
      "ticket_created_at": "2026-10-15 11:25:00",
      "ticket_resolution_due_at": "2026-10-15 19:25:00",
      "ticket_assigned_to": "1",
      "ticket_contact_id": "4",
      "ticket_asset_id": "1",
      "ticket_client_id": "1",
      "tags": [ { "tag_id": 116, "tag_name": "Waiting on Vendor", "tag_kind": "ticket", "tag_color": "#ffc107", "tag_icon": "hourglass-half" } ]
    }
  ]
}
```

`ticket_id` is the record's id, and what other endpoints take. `ticket_prefix` and `ticket_number` make the number people see, such as TCK-93.

**Fields:** `ticket_id`, `ticket_prefix`, `ticket_number`, `ticket_source`, `ticket_category`, `ticket_subject`, `ticket_details`, `ticket_priority`, `ticket_status`, `ticket_sla_id`, `ticket_billable`, `ticket_schedule`, `ticket_onsite`, `ticket_vendor_ticket_number`, `ticket_feedback`, `ticket_url_key`, `ticket_created_at`, `ticket_updated_at`, `ticket_due_at`, `ticket_first_response_at`, `ticket_response_due_at`, `ticket_resolution_due_at`, `ticket_response_sla_met`, `ticket_resolution_sla_met`, `ticket_response_sla_alert_stage`, `ticket_resolution_sla_alert_stage`, `ticket_resolved_at`, `ticket_closed_at`, `ticket_archived_at`, `ticket_created_by`, `ticket_assigned_to`, `ticket_closed_by`, `ticket_vendor_id`, `ticket_client_id`, `ticket_contact_id`, `ticket_location_id`, `ticket_asset_id`, `ticket_quote_id`, `ticket_invoice_id`, `ticket_project_id`, `ticket_recurring_ticket_id`, `ticket_template_id`, `ticket_order`, `tags`. With `ticket_id`, also its status's `ticket_status_name`, `ticket_status_color`, `ticket_status_active`, `ticket_status_pauses_sla` and `ticket_status_order`.

### Create {#tickets-create}

| Field | Notes |
|---|---|
| `ticket_subject` | Required |
| `client_id` | The client. Leave it out for an internal ticket that isn't for any client. |
| `ticket_details` | The description. HTML is kept. |
| `ticket_priority` | `Low`, `Medium`, `High` or `Urgent`. Anything else is `Medium`. |
| `ticket_contact_id` | Who it's for - one of the client's contacts. Leave it out for the client's primary contact. |
| `ticket_asset_id` | One of the client's assets |
| `ticket_vendor_id`, `ticket_vendor_ticket_number` | A vendor it's with - the client's or yours - and their reference for it |
| `ticket_assigned_to` | An active agent's `technician_id`. An assigned ticket starts Open, and an unassigned one starts New. |
| `ticket_billable` | `1` if the time on it is billable |

A contact, asset or vendor that isn't the client's is left off. The ticket gets its number and SLA as any other ticket does, and its source is **API**. No email goes to the contact.

```
curl -X POST https://itflow.example.com/api/v1/tickets/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "ticket_subject": "Backup job failed on RDG-SRV-01", "ticket_details": "Veeam reported the 01:00 job failed: repository unreachable.", "ticket_priority": "High", "ticket_asset_id": 8}'
```

```json
{ "success": "True", "count": "1", "data": [ { "insert_id": 1880 } ] }
```

### Update {#tickets-update}

Send `ticket_id`, `client_id` (the ticket's own client), and any of the fields under [Create](#tickets-create) apart from `client_id`. Only what you send changes, and a closed ticket can't be changed. To change a ticket's status, add a [reply](#replies-create) with `ticket_status`, or resolve or close it.

```json
{ "api_key": "YOUR_API_KEY", "client_id": 1, "ticket_id": 1880, "ticket_assigned_to": 2, "ticket_priority": "Urgent" }
```

### Resolve and close {#tickets-resolve}

Both take `ticket_id` and `client_id`, the ticket's own client.

- **Resolve** sets the ticket to Resolved and records whether its resolution SLA was met. A ticket that hadn't had a first response gets one now.
- **Close** resolves the ticket if it isn't already, then closes it, as the key's agent. A closed ticket can't be changed any more.

To say why when you resolve, add a reply with `"ticket_status": 4` instead. See [Replies](#replies-create).

## Ticket replies {#replies}

| Endpoint | Does |
|---|---|
| GET `ticket_replies/read.php` | Lists replies, or gets one |
| POST `ticket_replies/create.php` | Adds a reply or note to a ticket |

### Read {#replies-read}

| Parameter | Does |
|---|---|
| `ticket_reply_id` | Just this reply |
| `ticket_id` | Just this ticket's replies, oldest first |
| `type` | `Internal` (notes), `Public` (replies to the client) or `Client` (the client's own replies) |
| `include_archived` | `1` to include archived replies |
| `client_id` | Just replies on this client's tickets |
| `limit`, `offset` | [Paging](/api/requests#paging) |

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "ticket_reply_id": "2553",
      "ticket_reply": "Repository share was offline after a NAS update. Remounted and re-ran the job - it completed.",
      "ticket_reply_type": "Internal",
      "ticket_reply_emailed": "0",
      "ticket_reply_emailed_to": null,
      "ticket_reply_time_worked": "00:25:00",
      "ticket_reply_created_at": "2026-10-22 00:37:54",
      "ticket_reply_by": "1",
      "ticket_reply_by_name": "Alex Morgan",
      "ticket_reply_ticket_id": "1880",
      "ticket_prefix": "TCK-",
      "ticket_number": "1868",
      "ticket_subject": "Backup job failed on RDG-SRV-01",
      "ticket_client_id": "1"
    }
  ]
}
```

`ticket_reply_by` is an agent's id on Internal and Public replies, and a contact's id on Client replies. `ticket_reply_by_name` is their name either way.

`ticket_reply_emailed` is `1` when a Public reply was emailed and `0` when one of your replies wasn't. It's `null` on a Client reply, and on one from before ITFlow kept this. `ticket_reply_emailed_to` is who it went to, as a JSON list - `[{"email": "praghavan@ravenwooddental.example", "name": "Priya Raghavan"}]`, with an empty name for a watcher.

**Fields:** `ticket_reply_id`, `ticket_reply`, `ticket_reply_type`, `ticket_reply_emailed`, `ticket_reply_emailed_to`, `ticket_reply_time_worked`, `ticket_reply_created_at`, `ticket_reply_updated_at`, `ticket_reply_archived_at`, `ticket_reply_by`, `ticket_reply_by_name`, `ticket_reply_ticket_id`, and the ticket's `ticket_prefix`, `ticket_number`, `ticket_subject` and `ticket_client_id`.

### Create {#replies-create}

| Field | Notes |
|---|---|
| `ticket_id` | Required |
| `ticket_reply` | Required. HTML is kept. |
| `ticket_reply_type` | `Internal`, a note only your team sees - the default - or `Public`, which emails the contact and anyone watching, and counts as the first response |
| `ticket_reply_time_worked` | Time to log, as `HH:MM:SS`. None if you leave it out. |
| `ticket_status` | Also set the ticket's status, by number. `4` resolves it. |
| `client_id` | The ticket's client. Needed when the key's agent can see only some clients. |

The reply is from the key's agent.

```
curl -X POST https://itflow.example.com/api/v1/ticket_replies/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "ticket_id": 1880, "ticket_reply": "Repository share was offline after a NAS update. Remounted and re-ran the job - it completed.", "ticket_reply_time_worked": "00:25:00", "ticket_status": 4}'
```

## Technicians {#technicians}

| Endpoint | Does |
|---|---|
| GET `technicians/read.php` | Lists your agents, with their role |
| GET `technicians/time.php` | Time worked, by ticket and technician |

### Read {#technicians-read}

| Parameter | Does |
|---|---|
| `technician_id` | Just this agent |
| `archived` | `1` to include archived agents |
| `limit`, `offset` | [Paging](/api/requests#paging) |

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "technician_id": "2", "technician_name": "Jordan Lee", "technician_email": "jordan@summitit.example", "technician_status": "1", "role_id": "2", "role_name": "Technician", "role_is_admin": "0", "technician_created_at": "2026-10-21 19:41:45", "technician_archived_at": null }
  ]
}
```

`technician_status` is `1` for active and `0` for disabled. Passwords and sign-in details are never included. Use `technician_id` for `ticket_assigned_to`.

### Time worked {#technicians-time}

| Parameter | Does |
|---|---|
| `year` | The year. This year if you leave it out. |
| `month` | `1` to `12`. Every month of the year if you leave it out. |
| `technician_id` | Just this agent's time |
| `client_id` | Just time on this client's tickets |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Each row is one technician's total on one ticket, from the time on their replies in that month or year. Tickets that aren't for a client are left out.

```
curl -G https://itflow.example.com/api/v1/technicians/time.php \
  --data-urlencode "api_key=YOUR_API_KEY" \
  --data-urlencode "year=2026" --data-urlencode "month=10"
```

```json
{
  "success": "True",
  "count": 2,
  "data": [
    { "ticket_id": "1863", "ticket_number": "TCK-1863", "ticket_subject": "Backup job reporting failures overnight", "client_id": "20", "company": "Ashford Legal Services", "technician_id": "1", "technician": "Alex Morgan", "time_worked": "01:25:00" },
    { "ticket_id": "820", "ticket_number": "TCK-820", "ticket_subject": "Outlook stuck on disconnected after password reset", "client_id": "8", "company": "Aurora Wellness Center", "technician_id": "1", "technician": "Alex Morgan", "time_worked": "00:30:00" }
  ]
}
```
