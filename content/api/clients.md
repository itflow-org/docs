---
title: Clients and contacts
description: API reference for clients, contacts, locations and vendors - reading, creating, changing, archiving and deleting them.
---

These endpoints need the **Clients** area of the key's role. See [Keys and permissions](/api/permissions).

## Clients {#clients}

| Endpoint | Does |
|---|---|
| GET `clients/read.php` | Lists clients, or finds one by name |
| POST `clients/create.php` | Adds a client |
| POST `clients/update.php` | Changes a client |
| POST `clients/archive.php` | Archives a client |
| POST `clients/unarchive.php` | Brings an archived client back |
| POST `clients/delete.php` | Deletes an archived client and everything of theirs |

### Read {#clients-read}

| Parameter | Does |
|---|---|
| `client_id` | Just this client |
| `client_name` | Clients with exactly this name. Every match is returned, without paging. |
| `limit`, `offset` | [Paging](/api/requests#paging) |

The list includes archived clients.

```
curl -G https://itflow.example.com/api/v1/clients/read.php \
  --data-urlencode "api_key=YOUR_API_KEY" \
  --data-urlencode "client_name=Ravenwood Dental Group"
```

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "client_id": "1",
      "client_name": "Ravenwood Dental Group",
      "client_type": "Healthcare",
      "client_website": "https://www.ravenwooddental.example",
      "client_currency_code": "USD",
      "client_abbreviation": "RDG",
      "client_archived_at": null,
      "tags": [ { "tag_id": 8, "tag_name": "Key Account", "tag_kind": "client", "tag_color": "#ffc107", "tag_icon": "star" } ]
    }
  ]
}
```

**Fields:** `client_id`, `client_name`, `client_type`, `client_website`, `client_referral`, `client_currency_code`, `client_reminders`, `client_tax_id_number`, `client_default_tax_id`, `client_tax_exempt`, `client_tax_exempt_number`, `client_tax_exempt_expires`, `client_abbreviation`, `client_lead`, `client_notes`, `client_favorite`, `client_created_at`, `client_updated_at`, `client_archived_at`, `client_accessed_at`, `tags`.

### Create {#clients-create}

Don't send `client_id` - the new client gets one, returned as `insert_id`.

| Field | Notes |
|---|---|
| `client_name` | Required |
| `client_type` | Such as "Healthcare" |
| `client_website` | `https://` is taken off |
| `client_referral` | How they found you |
| `client_rate` | Their hourly rate, such as `145` - see below |
| `client_currency_code` | Such as `USD`. Set it. A client made without one has no currency. |
| `client_net_terms` | Days they have to pay an invoice - see below |
| `client_tax_id_number` | Their tax ID |
| `client_abbreviation` | Up to 6 characters |
| `client_lead` | `1` for a lead, `0` for a client |
| `client_notes` | |
| `client_default_tax_id` | The tax rate for their invoices - a [tax](/api/billing#taxes)'s `tax_id`, or `0` for your default |
| `client_tax_exempt` | `1` if they're tax exempt |
| `client_tax_exempt_number`, `client_tax_exempt_expires` | Their exemption certificate's number and expiry date |

```
curl -X POST https://itflow.example.com/api/v1/clients/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_name": "Allegheny Pet Hospital", "client_type": "Veterinary", "client_rate": 140, "client_net_terms": 30, "client_currency_code": "USD"}'
```

```json
{ "contract_id": 41, "success": "True", "count": "1", "data": [ { "insert_id": 27 } ] }
```

A client has no rate or payment terms of its own - they come from its [contract](/billing/contracts#in-force), else your defaults. When `client_rate` or `client_net_terms` differs from your defaults, the new client is given a contract called **Standard terms** that sets it, and its id comes back as `contract_id`. Change the client's terms on its contracts after that - with neither sent, or both your defaults, no contract is made.

A client made through the API has no locations or contacts yet. Add them with [locations](#locations-create) and [contacts](#contacts-create).

### Update, archive and unarchive {#clients-update}

Send `client_id` and any of the fields under [Create](#clients-create). Only what you send changes - but not `client_rate` or `client_net_terms`: a client's terms are its contract's, so they're left alone, and the answer says so in `not_kept`.

```json
{ "api_key": "YOUR_API_KEY", "client_id": 27, "client_type": "Veterinary", "client_notes": "Two clinics, one front desk." }
```

`archive.php` and `unarchive.php` take just `client_id`. Archiving a client also stops their recurring invoices.

### Delete {#clients-delete}

`delete.php` takes `client_id`, and needs **Full** on Clients. The client has to be archived first.

> [!WARNING]
> Deleting a client deletes everything of theirs: contacts, locations, assets, tickets and their replies, invoices, quotes and payments, documents, files, credentials and the rest. It can't be undone. A client whose money has cleared on a reconciled bank statement can't be deleted.

## Contacts {#contacts}

| Endpoint | Does |
|---|---|
| GET `contacts/read.php` | Lists contacts, or finds one |
| POST `contacts/create.php` | Adds a contact to a client |
| POST `contacts/update.php` | Changes a contact |
| POST `contacts/archive.php` | Archives a contact, and their client portal sign-in |
| POST `contacts/unarchive.php` | Brings an archived contact back |
| POST `contacts/delete.php` | Deletes an archived contact |

### Read {#contacts-read}

| Parameter | Does |
|---|---|
| `contact_id` | Just this contact |
| `contact_email` | Contacts with exactly this email address |
| `contact_phone_or_mobile` | The first contact with this phone or mobile number. ITFlow keeps numbers as digits only, so send digits only, such as `4125550101`. |
| `client_id` | Just this client's contacts |
| `limit`, `offset` | [Paging](/api/requests#paging) |

The list includes archived contacts.

```
curl -G https://itflow.example.com/api/v1/contacts/read.php \
  --data-urlencode "api_key=YOUR_API_KEY" \
  --data-urlencode "contact_email=dprescott@ravenwooddental.example"
```

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "contact_id": "2",
      "contact_name": "Dana Prescott",
      "contact_title": "Office Manager",
      "contact_email": "dprescott@ravenwooddental.example",
      "contact_phone": "4125550100",
      "contact_mobile": "4125550101",
      "contact_primary": "0",
      "contact_billing": "1",
      "contact_location_id": "1",
      "contact_client_id": "1",
      "tags": [ { "tag_id": 30, "tag_name": "Billing", "tag_kind": "contact", "tag_color": "#28a745", "tag_icon": "file-invoice-dollar" } ]
    }
  ]
}
```

**Fields:** `contact_id`, `contact_name`, `contact_title`, `contact_department`, `contact_email`, `contact_phone_country_code`, `contact_phone`, `contact_extension`, `contact_mobile_country_code`, `contact_mobile`, `contact_photo`, `contact_pin`, `contact_notes`, `contact_primary`, `contact_important`, `contact_billing`, `contact_technical`, `contact_ticket_emails`, `contact_company_ticket_emails`, `contact_location_id`, `contact_vendor_id`, `contact_user_id`, `contact_client_id`, `contact_created_at`, `contact_updated_at`, `contact_archived_at`, `contact_accessed_at`, `tags`.

### Create {#contacts-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `contact_name` | Required |
| `contact_email` | Required, and unique within the client |
| `contact_title`, `contact_department` | |
| `contact_phone`, `contact_extension`, `contact_mobile` | Digits are kept, anything else is taken out |
| `contact_location_id` | One of the client's [locations](#locations) |
| `contact_primary` | `1` makes them the client's primary contact, instead of whoever was |
| `contact_important`, `contact_billing`, `contact_technical` | `1` or `0` |
| `contact_notes` | |

```
curl -X POST https://itflow.example.com/api/v1/contacts/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "contact_name": "Janelle Ortiz", "contact_email": "jortiz@ravenwooddental.example", "contact_title": "Office Manager", "contact_mobile": "412-555-0144", "contact_location_id": 2, "contact_billing": 1}'
```

### Update, archive, unarchive and delete {#contacts-update}

Each takes `contact_id` and `client_id`, the contact's own client. `update.php` also takes any of the fields under [Create](#contacts-create), and changes only what you send. Archiving a contact also archives their client portal sign-in. `delete.php` needs **Full** on Clients, and the contact has to be archived first.

## Locations {#locations}

| Endpoint | Does |
|---|---|
| GET `locations/read.php` | Lists locations |
| POST `locations/create.php` | Adds a location to a client |
| POST `locations/update.php` | Changes a location |
| POST `locations/archive.php` | Archives a location |
| POST `locations/unarchive.php` | Brings an archived location back |
| POST `locations/delete.php` | Deletes an archived location |

### Read {#locations-read}

| Parameter | Does |
|---|---|
| `location_id` | Just this location |
| `client_id` | Just this client's locations |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Archived locations are left out.

```json
{
  "success": "True",
  "count": 2,
  "data": [
    { "location_id": "1", "location_name": "Main Office", "location_address": "1140 Ridge Avenue", "location_city": "Pittsburgh", "location_state": "PA", "location_zip": "15212", "location_primary": "1", "location_client_id": "1" },
    { "location_id": "2", "location_name": "Wexford Practice", "location_city": "Wexford", "location_primary": "0", "location_client_id": "1" }
  ]
}
```

**Fields:** `location_id`, `location_name`, `location_description`, `location_country`, `location_address`, `location_city`, `location_state`, `location_zip`, `location_phone_country_code`, `location_phone`, `location_phone_extension`, `location_fax_country_code`, `location_fax`, `location_hours`, `location_photo`, `location_primary`, `location_notes`, `location_favorite`, `location_contact_id`, `location_client_id`, `location_created_at`, `location_updated_at`, `location_archived_at`, `location_accessed_at`, `tags`.

### Create {#locations-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `location_name` | Required |
| `location_description` | |
| `location_address`, `location_city`, `location_state`, `location_zip`, `location_country` | |
| `location_hours` | Opening hours, such as "Mon-Fri 8-5" |
| `location_primary` | `1` makes it the client's primary location, instead of whichever was |
| `location_notes` | |

### Update, archive, unarchive and delete {#locations-update}

Each takes `location_id` and `client_id`, the location's own client. `update.php` also takes any of the fields under [Create](#locations-create). Only active locations can be changed. `delete.php` needs **Full** on Clients, and the location has to be archived first. Deleting a location takes it off everything that was there, such as contacts, assets and tickets.

## Vendors {#vendors}

A vendor belongs to a client - a supplier of theirs - or to no client, as one of your own suppliers.

| Endpoint | Does |
|---|---|
| GET `vendors/read.php` | Lists vendors |
| POST `vendors/create.php` | Adds a vendor |
| POST `vendors/update.php` | Changes a vendor |
| POST `vendors/archive.php` | Archives a vendor |
| POST `vendors/unarchive.php` | Brings an archived vendor back |

### Read {#vendors-read}

| Parameter | Does |
|---|---|
| `vendor_id` | Just this vendor |
| `client_id` | Just this client's vendors. `0` for your own. |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Archived vendors are left out.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "vendor_id": "2", "vendor_name": "Netgate", "vendor_phone": "512-555-0182", "vendor_website": "https://www.netgate.example", "vendor_account_number": "NG-90233", "vendor_client_id": "0" }
  ]
}
```

**Fields:** `vendor_id`, `vendor_name`, `vendor_description`, `vendor_contact_name`, `vendor_contact_phone_country_code`, `vendor_contact_phone`, `vendor_contact_email`, `vendor_phone_country_code`, `vendor_phone`, `vendor_extension`, `vendor_email`, `vendor_website`, `vendor_status_page`, `vendor_portal`, `vendor_hours`, `vendor_sla`, `vendor_code`, `vendor_account_number`, `vendor_notes`, `vendor_favorite`, `vendor_client_id`, `vendor_template_id`, `vendor_created_at`, `vendor_updated_at`, `vendor_archived_at`, `vendor_accessed_at`, `tags`.

### Create {#vendors-create}

| Field | Notes |
|---|---|
| `vendor_name` | Required |
| `client_id` | The client it's a vendor of. Leave it out for one of your own. |
| `vendor_description` | |
| `vendor_phone_country_code`, `vendor_phone`, `vendor_extension`, `vendor_email` | Their main phone and email. Phone numbers keep their digits only. |
| `vendor_contact_name`, `vendor_contact_phone_country_code`, `vendor_contact_phone`, `vendor_contact_email` | Your contact there |
| `vendor_website`, `vendor_status_page`, `vendor_portal` | `https://` is taken off |
| `vendor_account_number`, `vendor_code` | Your account number, and any PIN or code they ask for |
| `vendor_hours`, `vendor_sla` | Support hours and response times |
| `vendor_notes` | |

### Update, archive and unarchive {#vendors-update}

Each takes `vendor_id` and `client_id` - the vendor's client, or `0` for one of your own. `update.php` also takes any of the fields under [Create](#vendors-create). Only active vendors can be changed. Vendors can't be deleted through the API.
