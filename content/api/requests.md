---
title: Requests and responses
description: How to call ITFlow's API - reading with GET, writing with JSON, what comes back, paging through lists, the client a request is for, archived records and errors.
---

## Endpoints

Every endpoint is at `https://your-itflow/api/v1/`, followed by the kind of record and what to do with it:

| Action | Method | Does |
|---|---|---|
| `read.php` | GET | Lists records, or finds them |
| `create.php` | POST | Adds a record, and returns its id |
| `update.php` | POST | Changes a record |
| `archive.php`, `unarchive.php` | POST | Archives a record, or brings it back |
| `delete.php` | POST | Deletes a record for good |
| `resolve.php`, `close.php` | POST | Resolves or closes a ticket |

Not every kind of record has every action. Each one's page in the reference lists what it has.

## Reading {#reading}

Send a GET request with the parameters in the address, including your key as `api_key`. Encode the values for a URL. curl's `-G` with `--data-urlencode` does it for you, and in PowerShell, `[uri]::EscapeDataString()` does it:

```
curl -G https://itflow.example.com/api/v1/contacts/read.php \
  --data-urlencode "api_key=YOUR_API_KEY" \
  --data-urlencode "contact_email=dprescott@ravenwooddental.example"
```

With no other parameters, a read lists records. Most reads also take a record's id, such as `contact_id`, to get just that one, and some take a lookup, such as `contact_email`. Give one id or lookup at a time. If you give several, the endpoint uses the first of them in the order its reference lists them.

Lookups match the whole value, without regard to capitals. `contact_email=dprescott@ravenwooddental.example` finds Dana, but `contact_email=dprescott` doesn't.

## Writing {#writing}

Send a POST request with a JSON object as the body. Your key goes in it as `api_key`, with the record's fields:

```
curl -X POST https://itflow.example.com/api/v1/contacts/update.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "contact_id": 2, "contact_title": "Practice Manager"}'
```

- **Updates change only what you send.** Fields you leave out keep their values.
- **Dates** are `YYYY-MM-DD`, such as `2027-06-30`.
- **Yes or no** fields take `1` or `0`.
- **Ids** link records. For example, `contact_location_id` is a location's `location_id`, and `ticket_assigned_to` is an agent's `technician_id`.

## What comes back {#responses}

Every response is a JSON object:

| Field | What it is |
|---|---|
| `success` | `"True"` or `"False"` - as text, so compare it to `"True"` |
| `count` | How many records are in `data`. On an update, it's how many records changed. |
| `data` | The records - a list, even for one |
| `message` | What went wrong, when `success` is `"False"`. Some calls also say what they did here. |

A create returns the new record's id as `insert_id`:

```json
{ "success": "True", "count": "1", "data": [ { "insert_id": 93 } ] }
```

A record comes back with every field it has, named as ITFlow keeps them, such as `contact_name` or `asset_serial`:

- **Most values come back as text.** Numbers come back as `"145.00"`, yes-or-no fields as `"1"` or `"0"`, and anything not filled in as `null`. Convert them as you need. The few fields some endpoints work out, such as invoice tax totals, tags and role levels, are numbers.
- **Times** are `YYYY-MM-DD HH:MM:SS`, in the timezone set in [Admin > Settings](/admin/settings).
- **Tags.** A record that can be tagged comes with a `tags` list. See [Tags](/api/lookups#tags).

## Lists and paging {#paging}

A list returns 50 records unless you set `limit`, in the order they were added. To get the next page, set `offset` to the number of records already read:

| Parameter | Does |
|---|---|
| `limit` | How many records to return. 50 if you leave it out. |
| `offset` | How many to skip first. 0 if you leave it out. |

`count` is the number on this page, not the total. Keep asking for pages until one comes back with fewer than `limit`. When there is nothing left, the response is `"success": "False"`:

```powershell
$all = @(); $offset = 0; $limit = 100
do {
    $r = Invoke-RestMethod -Uri "$base/assets/read.php?api_key=$key&client_id=1&limit=$limit&offset=$offset"
    if ($r.success -ne 'True') { break }
    $all += $r.data
    $offset += $limit
} while ($r.data.Count -eq $limit)
```

## The client a request is for {#client-id}

Most records belong to a client, and `client_id` says which one.

- **On a read**, `client_id` narrows the list to that client, such as `assets/read.php?client_id=1`. It only ever narrows. A key never sees more than its agent can. `client_id=0` lists records that belong to no client, such as your own vendors.
- **On a write**, `client_id` is the client the record belongs to. A create puts the record under that client. An update, archive, delete, resolve or close only finds the record when `client_id` is the record's own client. Leave `client_id` out, or send `0`, for records that belong to no client.

When a key's agent can see only some clients, every write has to name one of those clients. See [Keys and permissions](/api/permissions#clients).

## Archived records {#archived}

Some reads leave archived records out, and some include them:

| Leave archived records out | Include them |
|---|---|
| documents, domains, locations, networks, licenses, vendors | clients, contacts, assets, credentials, certificates |
| services, technicians, taxes, tags, categories, roles - unless you add `archived=1` | tickets, invoices, quotes, products, expenses |
| ticket replies - unless you add `include_archived=1` | |

Check `..._archived_at`, such as `client_archived_at`, to tell the archived ones apart. Clients, contacts, credentials and locations have to be archived before they can be deleted.

## Errors {#errors}

| HTTP status | Means |
|---|---|
| 200, with `"success": "False"` | Most failures. Nothing was found, a required field was missing, it would make a duplicate, or the record doesn't belong to that client. `message` says which kind. |
| 400 | `invoice_items/read.php` needs `invoice_id` or `item_id` |
| 401 | No key, or a key that's wrong or has expired. With no key at all, the body is empty. |
| 403 | The key's agent isn't allowed to do it. `message` says what's missing. |
| 405 | The wrong method, such as GET on a create |
| 500 | ITFlow ran into an error. See [When something goes wrong](/install/troubleshooting#error-logs). |

The messages you'll see most:

- **"No resource (for this client and company) with the specified parameter(s)."** Nothing matched, or nothing the key's agent can see. An empty list looks the same.
- **"Auth success but insert query failed, ensure ALL required variables are provided..."** A create was turned down. A required field is missing, the record would be a duplicate, or the client doesn't exist.
- **"Auth success but update query failed/returned no results..."** An update found nothing to change. The id or `client_id` is wrong, or the ticket is closed. An update that sends only values the record already has comes back like this too.
- **"Auth success but delete query failed..."** The id or `client_id` is wrong, or the record hasn't been archived first.

ITFlow writes each failed call to [Admin > App Logs](/admin/logs#app-logs), with the endpoint and the key's name.

## What ITFlow records {#logging}

- Every change made through the API is in [Admin > Audit Logs](/admin/logs) under the key's agent, marked "via API" with the key's name. Ticket changes are also in the ticket's history.
- [Admin > API Keys](/admin/api-keys) shows when each key was last used and from where, and its calls by day and endpoint.
- Calls with a wrong or expired key are logged too. When as many come from one address in 10 minutes as **Tell admins** in [Security and sign-in](/admin/security#failed-sign-ins) allows, ITFlow alerts your admins.

> [!TIP]
> A key sent in the address of a GET request ends up in your web server's access log. Keep that log private. Alternatively, send the key in a JSON body on reads too, as you would on a write - ITFlow accepts it either way.
