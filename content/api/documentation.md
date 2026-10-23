---
title: IT documentation
description: API reference for assets, networks, credentials, licenses, domains, certificates, services and documents.
---

These endpoints need the **Support** area of the key's role, apart from credentials, which need **Credentials**. See [Keys and permissions](/api/permissions).

## Assets {#assets}

| Endpoint | Does |
|---|---|
| GET `assets/read.php` | Lists assets, or finds them |
| POST `assets/create.php` | Adds an asset |
| POST `assets/update.php` | Changes an asset |
| POST `assets/delete.php` | Deletes an asset |

### Read {#assets-read}

| Parameter | Does |
|---|---|
| `asset_id` | Just this asset |
| `asset_type` | Assets of this type, such as `Server` or `Firewall/Router` |
| `asset_name` | Assets with exactly this name |
| `asset_serial` | Assets with this serial number |
| `asset_mac` | The asset whose primary network interface has this MAC address, as ITFlow has it, such as `B0:4F:13:2A:9C:11` |
| `asset_uri`, `asset_uri_2` | Assets with this link |
| `client_id` | Just this client's assets |
| `limit`, `offset` | [Paging](/api/requests#paging) |

The list and `asset_mac` include each asset's primary network interface - its IP and MAC address and network. The other lookups return the asset alone. The list includes archived assets.

```
curl -G https://itflow.example.com/api/v1/assets/read.php \
  --data-urlencode "api_key=YOUR_API_KEY" \
  --data-urlencode "client_id=1" --data-urlencode "limit=1"
```

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "asset_id": "1",
      "asset_type": "Firewall/Router",
      "asset_name": "RDG-FW-01",
      "asset_make": "Netgate",
      "asset_model": "6100 MAX",
      "asset_serial": "F687F5FEB2",
      "asset_os": "pfSense Plus 24.11",
      "asset_status": "Deployed",
      "asset_warranty_expire": "2028-11-08",
      "asset_location_id": "1",
      "asset_client_id": "1",
      "interface_ip": "192.168.10.11",
      "interface_mac": "02:56:C0:D6:2E:2C",
      "interface_network_id": "1",
      "tags": [ { "tag_id": 65, "tag_name": "Business Critical", "tag_kind": "asset", "tag_color": "#d81b60", "tag_icon": "exclamation-circle" } ]
    }
  ]
}
```

**Fields:** `asset_id`, `asset_type`, `asset_name`, `asset_description`, `asset_make`, `asset_model`, `asset_serial`, `asset_os`, `asset_uri`, `asset_uri_2`, `asset_uri_client`, `asset_status`, `asset_purchase_reference`, `asset_purchase_date`, `asset_warranty_expire`, `asset_install_date`, `asset_photo`, `asset_physical_location`, `asset_notes`, `asset_favorite`, `asset_vendor_id`, `asset_location_id`, `asset_contact_id`, `asset_client_id`, `asset_product_id`, `asset_invoice_id`, `asset_invoice_item_id`, `asset_created_at`, `asset_updated_at`, `asset_archived_at`, `asset_accessed_at`, `tags`. With the interface: `interface_id`, `interface_name`, `interface_description`, `interface_type`, `interface_mac`, `interface_ip`, `interface_nat_ip`, `interface_ipv6`, `interface_vlans`, `interface_notes`, `interface_primary`, `interface_network_id`.

### Create {#assets-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `asset_name` | Required |
| `asset_type` | `Laptop`, `Desktop`, `Server`, `Virtual Machine`, `Phone`, `Mobile Phone`, `Tablet`, `Firewall/Router`, `Switch`, `Access Point`, `Printer`, `Display`, `Camera` or `Other` |
| `asset_make`, `asset_model`, `asset_serial`, `asset_os` | |
| `asset_description` | |
| `asset_status` | One of your asset statuses, such as `Deployed` - see [categories](/api/lookups#categories) |
| `asset_purchase_date`, `asset_warranty_expire`, `asset_install_date` | Dates |
| `asset_uri` | A link to it, such as its management page |
| `asset_location_id`, `asset_contact_id` | One of the client's [locations](/api/clients#locations) and [contacts](/api/clients#contacts) |
| `asset_vendor_id` | A [vendor](/api/clients#vendors) |
| `asset_ip`, `asset_mac`, `asset_network_id` | Its primary network interface: IP address, MAC address and [network](#networks) |
| `asset_notes` | |

```
curl -X POST https://itflow.example.com/api/v1/assets/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "asset_name": "RDG-WS-14", "asset_type": "Desktop", "asset_make": "Dell", "asset_model": "OptiPlex 7020", "asset_serial": "H7Q2LM3", "asset_os": "Windows 11 Pro", "asset_ip": "192.168.10.64", "asset_mac": "B0:4F:13:2A:9C:11", "asset_network_id": 1, "asset_location_id": 1, "asset_status": "Deployed"}'
```

### Update {#assets-update}

Send `asset_id`, `client_id` (the asset's own client), and any of the fields under [Create](#assets-create), or `asset_uri_2` for a second link.

> [!WARNING]
> An update sets the asset's primary IP address, MAC address and network to what you send, and clears them when you don't send them. Send `asset_ip`, `asset_mac` and `asset_network_id` with every update.

### Delete {#assets-delete}

`delete.php` takes `asset_id` and `client_id`, and needs **Full** on Support. It also deletes the asset's network interfaces and takes it out of its rack. Credentials linked to it stay with the client.

## Networks {#networks}

| Endpoint | Does |
|---|---|
| GET `networks/read.php` | Lists networks, or finds one by name |
| POST `networks/create.php` | Adds a network |
| POST `networks/update.php` | Changes a network |
| POST `networks/archive.php` | Archives a network |
| POST `networks/unarchive.php` | Brings an archived network back |

### Read {#networks-read}

| Parameter | Does |
|---|---|
| `network_id` | Just this network |
| `network_name` | Networks with exactly this name |
| `client_id` | Just this client's networks |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Archived networks are left out.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "network_id": "1", "network_name": "Office LAN", "network": "192.168.10.0/24", "network_vlan": "10", "network_gateway": "192.168.10.1", "network_dhcp_range": "192.168.10.50 - 192.168.10.220", "network_location_id": "1", "network_client_id": "1" }
  ]
}
```

**Fields:** `network_id`, `network_name`, `network_description`, `network_type`, `network_vlan`, `network`, `network_subnet`, `network_gateway`, `network_primary_dns`, `network_secondary_dns`, `network_dhcp_range`, `network_notes`, `network_favorite`, `network_location_id`, `network_vendor_id`, `network_client_id`, `network_created_at`, `network_updated_at`, `network_archived_at`, `network_accessed_at`, `tags`.

### Create {#networks-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `network_name` | Required |
| `network` | Required - the network and its size, such as `192.168.30.0/24` |
| `network_vlan` | VLAN number |
| `network_gateway`, `network_primary_dns`, `network_secondary_dns` | |
| `network_dhcp_range` | Such as `192.168.30.100-192.168.30.200` |
| `network_location_id` | One of the client's [locations](/api/clients#locations) |
| `network_description`, `network_notes` | |

### Update, archive and unarchive {#networks-update}

Each takes `network_id` and `client_id`, the network's own client. `update.php` also takes any of the fields under [Create](#networks-create). Only active networks can be changed. Networks can't be deleted through the API.

## Credentials {#credentials}

Credentials need the **Credentials** area of the role, and the key's credential decryption password as `api_key_decrypt_password` - on reads too. See [Credentials](/api/permissions#credentials).

| Endpoint | Does |
|---|---|
| GET `credentials/read.php` | Lists credentials, or gets one, with the username and password |
| POST `credentials/create.php` | Adds a credential |
| POST `credentials/update.php` | Changes a credential |
| POST `credentials/archive.php` | Archives a credential |
| POST `credentials/unarchive.php` | Brings an archived credential back |
| POST `credentials/delete.php` | Deletes an archived credential |

### Read {#credentials-read}

| Parameter | Does |
|---|---|
| `api_key_decrypt_password` | Required, in a JSON body |
| `credential_id` | Just this credential |
| `client_id` | Just this client's credentials |
| `limit`, `offset` | [Paging](/api/requests#paging) |

The list includes archived credentials.

```
curl -X GET "https://itflow.example.com/api/v1/credentials/read.php?api_key=YOUR_API_KEY&credential_id=1" \
  -H "Content-Type: application/json" \
  -d '{"api_key_decrypt_password": "YOUR_DECRYPTION_PASSWORD"}'
```

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "credential_id": "1",
      "credential_name": "Firewall Administrator",
      "credential_uri": "https://192.168.10.1",
      "credential_username": "msp-admin",
      "credential_password": "A265CDE06D86CE!aA1",
      "credential_otp_secret": "",
      "credential_password_changed_at": "2026-09-26 16:10:00",
      "credential_asset_id": "1",
      "credential_client_id": "1",
      "tags": [ { "tag_id": 52, "tag_name": "Rotate Quarterly", "tag_kind": "credential", "tag_color": "#6f42c1", "tag_icon": "sync-alt" } ]
    }
  ]
}
```

**Fields:** `credential_id`, `credential_name`, `credential_description`, `credential_category`, `credential_uri`, `credential_uri_2`, `credential_username`, `credential_password`, `credential_otp_secret`, `credential_note`, `credential_favorite`, `credential_password_changed_at`, `credential_folder_id`, `credential_contact_id`, `credential_asset_id`, `credential_client_id`, `credential_created_at`, `credential_updated_at`, `credential_archived_at`, `credential_accessed_at`, `tags`.

### Create {#credentials-create}

| Field | Notes |
|---|---|
| `api_key_decrypt_password` | Required |
| `credential_name` | Required |
| `credential_password` | Required |
| `client_id` | The client. Leave it out for one of your own, which needs a key that can see every client. |
| `credential_username` | |
| `credential_uri`, `credential_uri_2` | Where it signs in |
| `credential_otp_secret` | The two-step sign-in key, or its `otpauth://` link |
| `credential_contact_id`, `credential_asset_id` | The [contact](/api/clients#contacts) or [asset](#assets) it belongs to |
| `credential_description`, `credential_note` | |
| `credential_favorite` | `1` to make it a favourite |

A field too long to store is turned down with a message that names it, such as "credential_username is too long to store."

```
curl -X POST https://itflow.example.com/api/v1/credentials/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "api_key_decrypt_password": "YOUR_DECRYPTION_PASSWORD", "client_id": 1, "credential_name": "Imaging Server - local admin", "credential_username": "rdg-admin", "credential_password": "Tq7!mV2#pL9w", "credential_uri": "https://192.168.30.10", "credential_asset_id": 9}'
```

### Update, archive, unarchive and delete {#credentials-update}

Each takes `credential_id` and `client_id`, the credential's own client. `update.php` also needs `api_key_decrypt_password`, even when the password isn't changing, and takes any of the fields under [Create](#credentials-create). Changing `credential_password` records when it changed, for the [credential rotation report](/finance/reports). `delete.php` needs **Full** on Credentials, and the credential has to be archived first. Deleting one also deletes its shared links.

## Licenses {#licenses}

Licenses are called software in the API.

| Endpoint | Does |
|---|---|
| GET `software/read.php` | Lists licenses, or gets one |
| POST `software/archive.php` | Archives a license |
| POST `software/unarchive.php` | Brings an archived license back |

| Parameter | Does |
|---|---|
| `software_id` | Just this license |
| `client_id` | Just this client's licenses |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Archived licenses are left out of the list. `archive.php` and `unarchive.php` take `software_id` and `client_id`.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "software_id": "1", "software_name": "Microsoft 365 Business Premium", "software_type": "Software as a Service (SaaS)", "software_license_type": "Subscription", "software_seats": "26", "software_expire": "2026-12-25", "software_client_id": "1" }
  ]
}
```

**Fields:** `software_id`, `software_name`, `software_description`, `software_version`, `software_type`, `software_license_type`, `software_key`, `software_seats`, `software_purchase_reference`, `software_purchase`, `software_expire`, `software_notes`, `software_favorite`, `software_vendor_id`, `software_client_id`, `software_template_id`, `software_created_at`, `software_updated_at`, `software_archived_at`, `software_accessed_at`, `tags`.

## Domains {#domains}

| Endpoint | Does |
|---|---|
| GET `domains/read.php` | Lists domains, or finds one by name |
| POST `domains/create.php` | Adds a domain |
| POST `domains/update.php` | Changes a domain |
| POST `domains/archive.php` | Archives a domain |
| POST `domains/unarchive.php` | Brings an archived domain back |

### Read {#domains-read}

| Parameter | Does |
|---|---|
| `domain_id` | Just this domain |
| `domain_name` | The domain with this name, such as `ravenwooddental.example` |
| `client_id` | Just this client's domains |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Archived domains are left out.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "domain_id": "1",
      "domain_name": "ravenwooddental.example",
      "domain_expire": "2026-12-20",
      "domain_auto_renew": "0",
      "domain_ip": "203.0.113.10",
      "domain_name_servers": "ns1.harbourdns.example\nns2.harbourdns.example",
      "domain_mail_servers": "0 ravenwooddental.example.mail.protection.example",
      "domain_registrar": "13",
      "domain_refreshed_at": "2026-10-20 04:00:00",
      "domain_client_id": "1"
    }
  ]
}
```

**Fields:** `domain_id`, `domain_name`, `domain_description`, `domain_expire`, `domain_auto_renew`, `domain_ip`, `domain_name_servers`, `domain_mail_servers`, `domain_txt`, `domain_dmarc`, `domain_dkim`, `domain_raw_whois`, `domain_notes`, `domain_favorite`, `domain_registrar`, `domain_webhost`, `domain_dnshost`, `domain_mailhost`, `domain_client_id`, `domain_created_at`, `domain_updated_at`, `domain_archived_at`, `domain_accessed_at`, `domain_refreshed_at`, `tags`.

### Create {#domains-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `domain_name` | Required. It's tidied as ITFlow keeps domains: `https://www.Example.com/` becomes `example.com`. A client can't have the same domain twice. |
| `domain_expire` | When the registration expires. Anything that isn't a date is left out. |
| `domain_auto_renew` | `1` if it renews by itself |
| `domain_registrar`, `domain_dnshost`, `domain_webhost`, `domain_mailhost` | [Vendors](/api/clients#vendors) - the client's or yours - by `vendor_id` |
| `domain_description`, `domain_notes` | |

When a domain is saved, ITFlow looks it up, as the app does, filling in its IP address, name servers, mail servers, TXT, DMARC and DKIM records and WHOIS. The expiry from WHOIS, when it finds one, replaces `domain_expire`.

### Update, archive and unarchive {#domains-update}

Each takes `domain_id` and `client_id`, the domain's own client. `update.php` also takes any of the fields under [Create](#domains-create), looks the domain up again, and records what changed in the domain's history. Only active domains can be changed. Domains can't be deleted through the API.

## Certificates {#certificates}

| Endpoint | Does |
|---|---|
| GET `certificates/read.php` | Lists certificates, or finds one |
| POST `certificates/create.php` | Adds a certificate |

| Parameter | Does |
|---|---|
| `certificate_id` | Just this certificate |
| `certificate_name` | Certificates with exactly this name |
| `client_id` | Just this client's certificates |
| `limit`, `offset` | [Paging](/api/requests#paging) |

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "certificate_id": "1", "certificate_name": "www.ravenwooddental.example", "certificate_domain": "www.ravenwooddental.example", "certificate_issued_by": "Let's Encrypt", "certificate_expire": "2026-11-21", "certificate_check_status": "ok", "certificate_checked_at": "2026-10-20 03:30:00", "certificate_client_id": "1" }
  ]
}
```

**Fields:** `certificate_id`, `certificate_name`, `certificate_description`, `certificate_domain`, `certificate_names`, `certificate_issued_by`, `certificate_issued_at`, `certificate_expire`, `certificate_public_key`, `certificate_fingerprint`, `certificate_check_status`, `certificate_notes`, `certificate_favorite`, `certificate_checked_at`, `certificate_domain_id`, `certificate_client_id`, `certificate_created_at`, `certificate_updated_at`, `certificate_archived_at`, `certificate_accessed_at`.

### Create {#certificates-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `certificate_name` | A name for it. Needed if there's no `certificate_domain`. |
| `certificate_domain` | The host it's served on, such as `portal.example.com`, or `portal.example.com:8443` for another port |
| `certificate_public_key` | The certificate itself, as PEM. Its issuer, dates, names and fingerprint are taken from it. |
| `certificate_issued_by`, `certificate_expire` | When there's no PEM |
| `certificate_domain_id` | The client's [domain](#domains) it's for. Worked out from the host when you leave it out. |
| `certificate_description`, `certificate_notes` | |
| `certificate_favorite` | `1` to make it a favourite |

With a host, ITFlow connects to it as the certificate is saved, and records what it serves. Certificates can't be changed or deleted through the API.

## Services {#services}

| Endpoint | Does |
|---|---|
| GET `services/read.php` | Lists a client's services, or those due a review |

| Parameter | Does |
|---|---|
| `service_id` | Just this service, archived or not |
| `service_name` | Services with exactly this name |
| `review_due` | `1` for services whose review is due in the next 30 days or overdue, soonest first |
| `archived` | `1` to include archived services |
| `client_id` | Just this client's services |
| `limit`, `offset` | [Paging](/api/requests#paging) |

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "service_id": "8", "service_name": "Edge Firewall and Site VPN", "service_importance": "High", "service_review_due": "2026-10-02", "service_reviewed_at": "2026-04-05 14:30:00", "service_client_id": "2" }
  ]
}
```

**Fields:** `service_id`, `service_name`, `service_description`, `service_category`, `service_importance`, `service_backup`, `service_notes`, `service_favorite`, `service_review_due`, `service_reviewed_at`, `service_review_interval`, `service_client_id`, `service_created_at`, `service_updated_at`, `service_accessed_at`, `service_archived_at`, `tags`.

## Documents {#documents}

| Endpoint | Does |
|---|---|
| GET `documents/read.php` | Lists documents, or gets one |
| POST `documents/create.php` | Adds a document |
| POST `documents/update.php` | Changes a document, keeping the version before |
| POST `documents/archive.php` | Archives a document |
| POST `documents/unarchive.php` | Brings an archived document back |

### Read {#documents-read}

| Parameter | Does |
|---|---|
| `document_id` | Just this document |
| `client_id` | Just this client's documents |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Archived documents are left out. `document_content` is the document as HTML.

**Fields:** `document_id`, `document_name`, `document_description`, `document_content`, `document_content_raw`, `document_client_visible`, `document_favorite`, `document_folder_id`, `document_created_by`, `document_updated_by`, `document_reviewed_by`, `document_client_id`, `document_template_id`, `document_created_at`, `document_updated_at`, `document_archived_at`, `document_accessed_at`, `document_reviewed_at`, `tags`.

### Create {#documents-create}

| Field | Notes |
|---|---|
| `document_name` | Required |
| `document_content` | Required - the document, as HTML. Images in it as `data:` URLs are saved as files. |
| `client_id` | The client it's for |
| `document_description` | |
| `document_folder_id` | The client's folder to put it in |

```
curl -X POST https://itflow.example.com/api/v1/documents/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "document_name": "RDG - Imaging Server Notes", "document_description": "How the imaging server is set up", "document_content": "<h2>Imaging server</h2><p>RDG-SRV-02 runs the imaging database. Restart only after 6 PM.</p>"}'
```

### Update, archive and unarchive {#documents-update}

Each takes `document_id` and `client_id`, the document's own client. `update.php` also takes any of the fields under [Create](#documents-create). The document as it was is kept in its versions, as when it's edited in ITFlow.
