---
title: Calendar and trips
description: API reference for calendars and calendar events - with their attendees and invitations - and for trips.
---

## Calendars {#calendars}

| Endpoint | Does |
|---|---|
| GET `calendars/read.php` | Lists the calendars events go on |

It takes `calendar_id`, and `archived` - `1` to include archived calendars. Each has its `calendar_id`, `calendar_name` and `calendar_color`. Calendars are added with the **+** beside them on the [calendar](/service-desk/calendar), and their subscription links stay there.

## Events {#events}

| Endpoint | Does |
|---|---|
| GET `events/read.php` | Lists events, or gets one with who is on it |
| POST `events/create.php` | Puts an event on a calendar |
| POST `events/update.php` | Changes an event, or who is on it |
| POST `events/send.php` | Emails the invitation |
| POST `events/skip.php` | Skips one day of a repeating event |
| POST `events/delete.php` | Deletes an event |

An event with no client is anyone's, as on the [calendar](/service-desk/calendar). A client's event needs the **Clients** area of the key's role: **Read** to see it - or the key's agent made it or is on it - **Modify** to make or change one, and **Full** to delete one (Modify for one its agent made). See [Keys and permissions](/api/permissions).

### Read {#events-read}

| Parameter | Does |
|---|---|
| `event_id` | Just this event, with its `attendees` |
| `calendar_id` | Just this calendar's |
| `client_id` | Just this client's. `0` for those of no client. |
| `from`, `to` | Starting on or after, and on or before, these days - such as `2026-11-01` |
| `limit`, `offset` | [Paging](/api/requests#paging) |

A repeating event is one row: `event_repeat` - `Day`, `Week`, `Month` or `Year` - every `event_repeat_interval`, until `event_repeat_until`, without the days in `event_repeat_skip`. Each attendee has its `kind` - `agent`, `contact` or `guest` - `name`, `email` and `invited_at`, when it was sent the invitation.

**Fields:** `event_id`, `event_title`, `event_location`, `event_description`, `event_start`, `event_end`, `event_all_day`, `event_repeat`, `event_repeat_interval`, `event_repeat_until`, `event_repeat_skip`, `event_sequence`, `event_created_at`, `event_updated_at`, `event_created_by`, `event_client_id`, `event_location_id`, `event_calendar_id`, `calendar_name`.

### Create {#events-create}

| Field | Notes |
|---|---|
| `event_title` | Required |
| `event_calendar_id` | Required - see [Calendars](#calendars) |
| `event_start` | Required: `2026-11-20 14:00`, or a day - `2026-11-20` - with `event_all_day` |
| `event_end` | The same. An hour after the start if you leave it out. |
| `event_all_day` | `1` for a whole-day event |
| `client_id` | The client it's for. Leave it out for one that's nobody's. |
| `event_location` | Where, in words |
| `event_location_id` | One of the client's locations |
| `event_description` | |
| `event_repeat`, `event_repeat_interval`, `event_repeat_until` | `Week` and `2` is every other week. `event_repeat_until` is its last day. |
| `attendee_user_ids` | Agents on it, by `technician_id` |
| `attendee_contact_ids` | The client's contacts on it |
| `attendee_emails` | Anyone else, by email - a list, or separated by commas |
| `send_invites` | `1` emails each of them an invitation for their calendar |

The answer has `invited`, how many it was emailed to.

```
curl -X POST https://itflow.example.com/api/v1/events/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "event_title": "Onsite - patch panel cleanup", "event_calendar_id": 2, "event_start": "2026-11-20 14:00", "event_end": "2026-11-20 16:00", "attendee_user_ids": [2], "attendee_contact_ids": [1], "send_invites": 1}'
```

### Update, send, skip and delete {#events-update}

Each takes `event_id` and `client_id`.

- **Update** takes any of the fields under [Create](#events-create), and changes only what you send. `client_id` can move it to another client. Sending any of the attendee lists sets who is on it - a list you leave out stays. With `send_invites`, anyone new gets the invitation, those who have it get the change, and anyone taken off is told it's off for them. The answer has `emailed`.
- **Send** emails the invitation, as **Email the invitation** does: to those not sent it yet, and again, as an update, to those who were. ITFlow has to send mail.
- **Skip** takes `date`, one day of a repeating event to leave out, as **Skip this one** does. Those who have it get the series without that day.
- **Delete** tells those who have it in their calendar that it's off.

## Trips {#trips}

| Endpoint | Does |
|---|---|
| GET `trips/read.php` | Lists trips, or gets one |
| POST `trips/create.php` | Logs a trip |
| POST `trips/update.php` | Changes a trip |
| POST `trips/delete.php` | Deletes a trip |

Anyone logs and changes their own [trips](/billing/trips). Seeing everyone's needs **Read** on Financial, logging or changing someone else's **Modify**, and deleting someone else's **Full**.

### Read {#trips-read}

| Parameter | Does |
|---|---|
| `trip_id` | Just this trip |
| `client_id` | Just this client's. `0` for trips for no client. |
| `user_id` | Just this driver's |
| `from`, `to` | Driven on or after, and on or before, these days |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Each trip has its `driver_name` and `client_name`. `trip_miles` is the whole trip - there and back for a `round_trip`.

**Fields:** `trip_id`, `trip_date`, `trip_purpose`, `trip_source`, `trip_destination`, `trip_start_odometer`, `trip_end_odometer`, `trip_miles`, `round_trip`, `trip_own_vehicle`, `trip_expense_id`, `trip_billable`, `trip_invoice_id`, `trip_invoice_item_id`, `trip_created_at`, `trip_updated_at`, `trip_user_id`, `trip_client_id`, `trip_location_id`, `trip_ticket_id`, `trip_created_by`, `driver_name`, `client_name`.

### Create, update and delete {#trips-create}

| Field | Notes |
|---|---|
| `trip_destination` | Required: where it went |
| `trip_purpose` | Required: what it was for |
| `trip_miles` | The distance one way - required without both odometer readings |
| `trip_date` | Today if you leave it out |
| `trip_source` | Where it started. Your company's address if you leave it out. |
| `round_trip` | `1` for there and back - the distance is doubled |
| `trip_start_odometer`, `trip_end_odometer` | Whole numbers. With both, the distance is the difference. |
| `client_id` | The client it was for |
| `trip_location_id`, `trip_ticket_id` | One of the client's sites, and tickets |
| `trip_user_id` | Who drove. The key's agent if you leave it out. |
| `trip_own_vehicle` | `1` for their own car, paid back for the distance |
| `trip_billable` | `1` to bill it to the client |

Update takes `trip_id` and changes only what you send. A trip paid back for keeps its driver, vehicle and distance, and one billed its client and distance. Delete takes `trip_id`, and a trip paid back for or billed can't be deleted. A field that won't do is refused with `400` and why in `message`.

```json
{ "api_key": "YOUR_API_KEY", "client_id": 1, "trip_source": "Office", "trip_destination": "Ravenwood Dental, 410 Grant St", "trip_purpose": "Patch panel cleanup", "trip_miles": 12.3, "round_trip": 1, "trip_billable": 1 }
```
