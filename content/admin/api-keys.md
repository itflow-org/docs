---
title: API keys
description: Let other systems - your RMM, a PSA sync, a script - read and write ITFlow through its API, as one of your agents, until the key expires.
where: Admin > API Keys
access: Admins
---

ITFlow has an API, so other systems can read and write it: an RMM raising tickets from alerts, a script adding assets, a sync with another tool. Each system needs an API key.

A key acts as one of your agents. It can do what that agent's role allows, for the clients they can see, and its calls show in the audit log as them - so give each system an agent of its own, with only the access it needs. Make that agent an [API / service account](/admin/users#service-accounts), and it stays out of the calendar, the pickers and the reports, and can't sign in.

## Make a key

1. Go to **Admin > API Keys** and click **New API Key**.
2. On **Details**, give it a **Name** that says what uses it - "RMM alerts", "Asset sync".
3. Set when it **Expires**. It works until the start of that day.
4. Pick the agent it **Acts as**.
5. On **Key**, copy the **API key** and the **Credential decryption password**. They aren't shown again.
6. Tick that you've copied them, and click **Create**.

![The New API Key window](adm-api-key-new.webp "New API Key: what uses it, when it expires, and the agent it acts as")

The credential decryption password is only needed by systems that read or write client passwords. It's sent with those calls, in the body, so it never ends up in web server logs.

## Keep track of keys

![API keys](adm-api-keys.webp "API keys: each key, who it acts as, and when it was last used")

The list shows each key with who it **Acts as**, what it **Can open** and which clients, whether it works, when it was **Last used** and from where, and its **Calls** over the last 30 days - click them to see what it was used for.

A key stops working when it expires, or when its agent is disabled, archived or has no role. Revoking a key expires it straight away; it moves to **Expired**, where it can be deleted.

### Keys sent in the address {#address}

A key sent in a call's address, as `?api_key=`, is in your web server's access log. The list flags it under **Last used** - **In the address** and when - and a note at the top counts the keys sent that way in the last 30 days. Move each of those scripts to the `X-API-Key` header, give it a new key and revoke the old one, as the old logs still have it. Then turn off **Take API keys in the address** in [Security](/admin/security#api-keys), so a key in the address is turned away from then on.

## Using the API

Calls go to `https://your-itflow/api/v1/`, with the key in the `X-API-Key` header:

```
curl "https://itflow.example.com/api/v1/tickets/read.php?client_id=12" \
  -H "X-API-Key: YOUR_API_KEY"
```

Don't put the key in the address as `?api_key=`. It still works for older scripts, but your web server's access log keeps the address of every request, key and all. See [Your key](/api/requests#key).

[The API section](/api/overview) has everything else: how to call it, what a key can see, examples, and every endpoint.

> [!WARNING]
> Treat a key like a password: it can do whatever its agent can. Give it an expiry date, give it an agent with only the access it needs, and revoke it when the system using it is retired.
