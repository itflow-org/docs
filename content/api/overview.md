---
title: Getting started with the API
description: What ITFlow's API can do, how to get a key, and your first calls with curl and PowerShell.
---

ITFlow's API lets other systems read and write ITFlow over HTTPS:

- An RMM raises a ticket when an alert fires, then resolves it when the alert clears.
- A phone system looks up who's calling.
- A script keeps assets in step with what your RMM sees.
- A report pulls the month's time from every technician.

Each API key acts as one of your agents. It can do what that agent's role allows, for the clients they can see, and everything it does is in the audit log under their name. See [Keys and permissions](/api/permissions).

## Make a key

In ITFlow, go to [Admin > API Keys](/admin/api-keys) and click **New API Key**. Give it a name that says what uses it, a date it expires, and the agent it acts as. Copy the **API key** before you close the window, because it isn't shown again.

Give each system that uses the API an agent of its own, with only the access it needs. Then its calls are easy to pick out, and you can switch one off without breaking the others.

## Your first call

Every endpoint is a PHP file under `api/v1/` on your ITFlow, named for the kind of record and what it does with it, such as `clients/read.php` or `tickets/create.php`.

To list your clients, send a **GET** request with the key as `api_key`. With curl:

```
curl -G https://itflow.example.com/api/v1/clients/read.php \
  --data-urlencode "api_key=YOUR_API_KEY" \
  --data-urlencode "limit=2"
```

Or with PowerShell:

```powershell
$base = 'https://itflow.example.com/api/v1'
$key  = 'YOUR_API_KEY'

$r = Invoke-RestMethod -Uri "$base/clients/read.php?api_key=$key&limit=2"
$r.data | Select-Object client_id, client_name
```

ITFlow answers with JSON:

```json
{
  "success": "True",
  "count": 2,
  "data": [
    { "client_id": "1", "client_name": "Ravenwood Dental Group", "client_type": "Healthcare" },
    { "client_id": "2", "client_name": "Kestrel Precision Manufacturing", "client_type": "Manufacturing" }
  ]
}
```

Each record comes back with all its fields. The examples in these pages show only some of them.

## Make a change

To create, change or remove something, send a **POST** request with a JSON body. The key goes in the body, with the record's fields. To raise a ticket for client 1:

```
curl -X POST https://itflow.example.com/api/v1/tickets/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "ticket_subject": "Backup job failed on RDG-SRV-01", "ticket_priority": "High"}'
```

```powershell
$body = @{
    api_key         = $key
    client_id       = 1
    ticket_subject  = 'Backup job failed on RDG-SRV-01'
    ticket_priority = 'High'
} | ConvertTo-Json

$r = Invoke-RestMethod -Method Post -Uri "$base/tickets/create.php" -ContentType 'application/json' -Body $body
$r.data[0].insert_id
```

```json
{ "success": "True", "count": "1", "data": [ { "insert_id": 1880 } ] }
```

`insert_id` is the new ticket's `ticket_id`.

> [!WARNING]
> `success` is the text `"True"` or `"False"`, not true or false. In PowerShell, JavaScript and Python, the text `"False"` counts as true when you test it on its own. Compare it instead, with `$r.success -eq 'True'` or `r["success"] == "True"`.

## Next

- [Requests and responses](/api/requests) - parameters, paging, the client a request is for, and errors
- [Keys and permissions](/api/permissions) - what a key can see and change
- [Examples](/api/examples) - an RMM alert, a caller lookup, an asset sync and a time report
- The reference: [clients and contacts](/api/clients), [tickets](/api/tickets), [IT documentation](/api/documentation), [billing](/api/billing), and [tags, categories and roles](/api/lookups)
