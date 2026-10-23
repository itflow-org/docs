---
title: Keys and permissions
description: An API key acts as one of your agents - what that means for what it can read and change, which clients it sees, and reading credentials.
---

Every API key acts as the agent chosen when it was made. It can do what that agent's [role](/admin/roles) allows, only for [the clients they can see](/admin/users#which-clients-they-see), and its changes are recorded under their name. There's nothing separate to set up for the API. Change the agent's role or client access and the key changes with them.

A key stops working when it expires, when it's revoked, or when its agent is disabled, archived or loses their role. See [API keys](/admin/api-keys).

## What each endpoint needs {#modules}

Each kind of record belongs to an area of the role:

| Records | Role area |
|---|---|
| Clients, contacts, locations, vendors | Clients |
| Tickets, ticket replies, technicians, assets, networks, licenses, domains, certificates, services, documents | Support |
| Credentials | Credentials |
| Invoices, invoice items, quotes, products, taxes | Sales |
| Expenses | Financial |

What a call does sets the level it needs in that area:

| Call | Needs |
|---|---|
| `read.php`, `technicians/time.php` | Read |
| `create.php`, `update.php`, `archive.php`, `unarchive.php`, `resolve.php`, `close.php` | Modify |
| `delete.php` | Full |

An admin role can do everything. When the agent doesn't have the level, the call is turned away with a 403 that says what's missing:

```json
{
  "success": "False",
  "message": "This needs Full on Support - the key's user, Jordan Lee (Technician), has Modify. An admin can change their role in Admin > Roles."
}
```

[Tags](/api/lookups#tags) and [categories](/api/lookups#categories) follow the kind of record they're for. An asset's tags need Support, and expense categories need Financial. Only admins can make tags. Anyone can read [roles](/api/lookups#roles), but an agent who isn't an admin sees only their own role.

## Which clients a key sees {#clients}

An agent can be limited to some clients, in **Admin > Users** under **Client access**. Their key is limited the same way:

- **Reads** return only records of the clients they can see, and records that belong to no client. Asking for another client's record finds nothing.
- **Writes** have to name, in `client_id`, a client they can see. A key limited to some clients can't create or change records that belong to no client.

A write for a client outside the agent's access is turned away:

```json
{
  "success": "False",
  "message": "The user linked to this API key does not have access to the target client for this write."
}
```

An agent who can see every client - every admin, and anyone whose access isn't limited - has no such limit.

## Credentials {#credentials}

Passwords in ITFlow are encrypted. To read or write [credentials](/api/documentation#credentials), send the key's **credential decryption password** as `api_key_decrypt_password`. It was shown with the key when the key was made.

It goes in a JSON body - on a read too, so a GET request carries a body:

```
curl -X GET "https://itflow.example.com/api/v1/credentials/read.php?api_key=YOUR_API_KEY&credential_id=1" \
  -H "Content-Type: application/json" \
  -d '{"api_key_decrypt_password": "YOUR_DECRYPTION_PASSWORD"}'
```

Without it, a read finds nothing. With the wrong one, the username and password come back as `false`.

> [!NOTE]
> Windows PowerShell 5.1 can't send a body with a GET request. Use PowerShell 7, or `curl.exe`, which comes with Windows 10 and 11.

## Keeping keys safe {#safety}

- Give each system its own key and its own agent, with only the role and clients it needs. A key for an RMM that raises tickets doesn't need Credentials or Financial.
- Set an expiry date, and revoke the key in [Admin > API Keys](/admin/api-keys) when the system using it is retired.
- Keep keys and decryption passwords in your RMM's or password manager's secret store, not written into scripts.
- Only call the API over HTTPS. A key and decryption password together can read every password their agent can see.
