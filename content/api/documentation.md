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
| POST `assets/archive.php` | Archives an asset |
| POST `assets/unarchive.php` | Brings an archived asset back |
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

The list and `asset_mac` include each asset's primary network interface - its IP and MAC address and network. The other lookups return the asset alone. The list includes archived assets. Every asset comes with its details as `asset_specs` - see [Details](#assets-details).

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
      "tags": [ { "tag_id": 65, "tag_name": "Business Critical", "tag_kind": "asset", "tag_color": "#d81b60", "tag_icon": "exclamation-circle" } ],
      "asset_specs": { "ports": "6", "sfp_ports": "2" }
    }
  ]
}
```

**Fields:** `asset_id`, `asset_type`, `asset_name`, `asset_description`, `asset_make`, `asset_model`, `asset_serial`, `asset_os`, `asset_uri`, `asset_uri_2`, `asset_uri_client`, `asset_status`, `asset_purchase_reference`, `asset_purchase_date`, `asset_warranty_expire`, `asset_install_date`, `asset_photo`, `asset_physical_location`, `asset_notes`, `asset_favorite`, `asset_vendor_id`, `asset_location_id`, `asset_contact_id`, `asset_client_id`, `asset_product_id`, `asset_invoice_id`, `asset_invoice_item_id`, `asset_created_at`, `asset_updated_at`, `asset_archived_at`, `asset_accessed_at`, `tags`. With the interface: `interface_id`, `interface_name`, `interface_description`, `interface_type`, `interface_mac`, `interface_ip`, `interface_nat_ip`, `interface_ipv6`, `interface_vlans`, `interface_notes`, `interface_primary`, `interface_network_id`. And `asset_specs`, its details (`{}` for none).

### Create {#assets-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `asset_name` | Required |
| `asset_type` | `Laptop`, `Desktop`, `Server`, `NAS`, `Virtual Machine`, `Firewall/Router`, `Switch`, `Access Point`, `Modem/ONT`, `UPS`, `PDU`, `Printer`, `Phone`, `Mobile Phone`, `Tablet`, `Display`, `Camera`, `NVR/DVR` or `Other` - in any capitals, saved as written here |
| `asset_make`, `asset_model`, `asset_serial`, `asset_os` | |
| `asset_description` | |
| `asset_status` | One of your asset statuses, such as `Deployed` - see [categories](/api/lookups#categories) |
| `asset_purchase_date`, `asset_warranty_expire`, `asset_install_date` | Dates |
| `asset_uri` | A link to it, such as its management page |
| `asset_location_id`, `asset_contact_id` | One of the client's [locations](/api/clients#locations) and [contacts](/api/clients#contacts) |
| `asset_vendor_id` | A [vendor](/api/clients#vendors) |
| `asset_ip`, `asset_mac`, `asset_network_id` | Its primary network interface: IP address, MAC address and [network](#networks) |
| `asset_notes` | |
| `asset_specs` | Its details, as `{"key": "value"}` - see [Details](#assets-details) |

```
curl -X POST https://itflow.example.com/api/v1/assets/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "asset_name": "RDG-WS-14", "asset_type": "Desktop", "asset_make": "Dell", "asset_model": "OptiPlex 7020", "asset_serial": "H7Q2LM3", "asset_os": "Windows 11 Pro", "asset_ip": "192.168.10.64", "asset_mac": "B0:4F:13:2A:9C:11", "asset_network_id": 1, "asset_location_id": 1, "asset_status": "Deployed"}'
```

### Update {#assets-update}

Send `asset_id`, `client_id` (the asset's own client), and any of the fields under [Create](#assets-create), or `asset_uri_2` for a second link. A field you don't send keeps what the asset has - its primary IP address, MAC address and network included.

`asset_specs` on an update is laid over the details the asset has: send just the ones to change, and `""` to clear one. When `asset_type` changes, the asset keeps only the details its new type has.

### Details {#assets-details}

`asset_specs` holds what only that kind of device has, by key. Each type takes its own, and a key it doesn't have is left out. A value a detail can't take isn't kept either, and the answer says why in `asset_specs_not_kept`, such as `["PoE budget: a number from 0 to 100000 W"]`.

| Type | Keys |
|---|---|
| `Laptop`, `Desktop`, `Server` | `cpu`, `ram_gb`, `storage` |
| `Virtual Machine` | `vm_host` (the id or name of one of the client's servers or NAS units), `vcpus`, `ram_gb`, `storage` |
| `NAS` | `drive_bays`, `drives`, `raw_tb`, `usable_tb`, `raid`, `ports` |
| `Firewall/Router` | `ports`, `sfp_ports` |
| `Switch` | `ports`, `sfp_ports`, `poe_watts`, `managed` (`Managed`, `Smart` or `Unmanaged`) |
| `Access Point` | `wifi` (`Wi-Fi 4 (802.11n)`, `Wi-Fi 5 (802.11ac)`, `Wi-Fi 6 (802.11ax)`, `Wi-Fi 6E` or `Wi-Fi 7 (802.11be)`) |
| `Modem/ONT` | `circuit_id`, `isp_account`, `ports` |
| `UPS` | `va`, `watts`, `runtime_min`, `outlets`, `battery_installed`, `battery_replace` (dates, `YYYY-MM-DD`) |
| `PDU` | `pdu_type` (`Basic`, `Metered`, `Monitored` or `Switched`), `outlets`, `power_input` |
| `Printer` | `color` (`Color` or `Black and white`), `supplies` |
| `Phone` | `extension` |
| `Mobile Phone`, `Tablet` | `phone_number`, `carrier`, `imei` |
| `Display` | `size_in`, `resolution` |
| `Camera` | `resolution` |
| `NVR/DVR` | `channels`, `storage`, `ports` |

`ports` and `sfp_ports` add the network interfaces the asset doesn't have yet when they are new or changed, as the asset form does - see [Details by type](/documentation/assets#details-by-type).

```
curl -X POST https://itflow.example.com/api/v1/assets/update.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "asset_id": 2, "asset_specs": {"ports": 24, "sfp_ports": 2, "poe_watts": 400, "managed": "Managed"}}'
```

### Archive and unarchive {#assets-archive}

Each takes `asset_id` and `client_id`, the asset's own client, and goes in the asset's history.

### Delete {#assets-delete}

`delete.php` takes `asset_id` and `client_id`, and needs **Full** on Support. It also deletes the asset's network interfaces and takes it out of its rack. Credentials linked to it stay with the client.

### Interfaces {#asset-interfaces}

An asset's ports and network cards.

| Endpoint | Does |
|---|---|
| GET `asset_interfaces/read.php` | An asset's interfaces, or one, with what each is plugged into |
| POST `asset_interfaces/create.php` | Adds an interface |
| POST `asset_interfaces/update.php` | Changes, plugs in or unplugs an interface |
| POST `asset_interfaces/delete.php` | Deletes an interface |

Read takes `asset_id` or `interface_id`, and `client_id`. Each interface has its `network_name`, and `connected_to`: the `interface_id`, `interface_name`, `asset_id` and `asset_name` at the other end of the cable, or `null`.

| Field | Notes |
|---|---|
| `asset_id` | Create only, required |
| `interface_name` | Required - its name or port number, such as `Gi1/0/24`. The asset can't have two with the same name. |
| `interface_type` | An [interface type](/admin/categories-and-tags), such as `SFP+` |
| `interface_ip` | An IP address, `DHCP`, or empty for none. It has to be inside its network. |
| `interface_network_id` | One of the client's [networks](#networks) |
| `interface_mac` | Six pairs, such as `00:1A:2B:3C:4D:5E` |
| `interface_nat_ip`, `interface_ipv6`, `interface_vlans` | `interface_vlans` such as `Trunk 1, 10, 20-29` |
| `interface_description`, `interface_notes` | |
| `interface_primary` | `1` makes it the asset's primary - the one its address shows by. The asset's first interface is its primary anyway. |
| `connected_to` | The `interface_id` it's plugged into, on another of the client's assets. `0` unplugs it. One cable per port: whatever either end was plugged into is let go. |

`client_id` is the asset's client. Update takes `interface_id` and changes only what you send. Delete needs **Full** on Support. The answer to create and update has `warnings` - such as the address being on another device too.

```
curl -X POST https://itflow.example.com/api/v1/asset_interfaces/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "asset_id": 8, "interface_name": "eth1", "interface_type": "Ethernet", "interface_network_id": 2, "interface_ip": "192.168.40.77", "connected_to": 33}'
```

### Notes {#asset-notes}

The notes on an asset's page - what was done, parts replaced, changes made.

| Endpoint | Does |
|---|---|
| GET `asset_notes/read.php` | An asset's notes, newest first, or one |
| POST `asset_notes/create.php` | Adds a note |
| POST `asset_notes/archive.php` | Archives a note |
| POST `asset_notes/unarchive.php` | Brings an archived note back |
| POST `asset_notes/delete.php` | Deletes an archived note |

Read takes `asset_id` or `asset_note_id`, with `limit` and `offset`. Archived notes are listed too. Each has `asset_note_created_by_name`, the agent who wrote it.

Create takes `asset_id`, `asset_note_type` - one of your [asset note types](/admin/categories-and-tags), such as `Repair` - and `asset_note`, both required. It's written by the key's agent. The others take `asset_note_id`. Delete needs **Full** on Support, and the note has to be archived first. Each takes `client_id`, the asset's client.

## Networks {#networks}

| Endpoint | Does |
|---|---|
| GET `networks/read.php` | Lists networks, or finds one by name |
| POST `networks/create.php` | Adds a network |
| POST `networks/update.php` | Changes a network |
| POST `networks/archive.php` | Archives a network |
| POST `networks/unarchive.php` | Brings an archived network back |
| POST `networks/delete.php` | Deletes an archived network |

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

### Update, archive, unarchive and delete {#networks-update}

Each takes `network_id` and `client_id`, the network's own client. `update.php` also takes any of the fields under [Create](#networks-create). Only active networks can be changed. `delete.php` needs **Full** on Support, and the network has to be archived first. The network interfaces on it stay, on no network.

### IP addresses {#network-ips}

The addresses documented on a network - its address plan.

| Endpoint | Does |
|---|---|
| GET `network_ips/read.php` | A network's addresses, lowest first, or one |
| POST `network_ips/create.php` | Documents an address, or a run of them |
| POST `network_ips/update.php` | Changes an address |
| POST `network_ips/delete.php` | Takes an address off the plan |

Read takes `network_id` or `ip_id`, with `limit` and `offset`.

| Field | Notes |
|---|---|
| `network_id` | Create only, required |
| `ip_address` | Required. The host part alone, such as `20` on a /24, is filled out from the subnet. |
| `ip_range_end` | Create only: the last address of a run - up to 256 at a time. Those outside the subnet or documented already are skipped. |
| `ip_type` | `Static` (fixed, the default), `Reservation` (a DHCP reservation), `Reserved` (held back) or `Virtual` (floating) |
| `ip_mac` | The device's MAC. A reservation needs one. |
| `ip_hostname`, `ip_description` | |

An address has to be inside the network's subnet and documented on it only once. Update takes `ip_id` and changes only what you send. Delete needs **Full** on Support. Each takes `client_id`, the network's client. The answer to create has `added` and `skipped`.

```json
{ "api_key": "YOUR_API_KEY", "network_id": 2, "ip_address": "238", "ip_range_end": "245", "ip_type": "Reserved", "ip_description": "Printer pool" }
```

## Racks {#racks}

| Endpoint | Does |
|---|---|
| GET `racks/read.php` | Lists a client's racks, or gets one with what's in it |
| POST `racks/create.php` | Adds a rack |
| POST `racks/update.php` | Changes a rack |
| POST `racks/archive.php` | Archives a rack |
| POST `racks/unarchive.php` | Brings an archived rack back |
| POST `racks/delete.php` | Deletes an archived rack |
| POST `rack_units/create.php` | Mounts an item in a rack |
| POST `rack_units/update.php` | Moves or changes an item |
| POST `rack_units/delete.php` | Takes an item out |

Read takes `rack_id`, or `client_id`, with `limit` and `offset`. Archived racks are listed too. With `rack_id` the rack has `units`, what's mounted in it, from U1 up: each item's `unit_start_number` to `unit_end_number`, `unit_face` (`front` or `rear`), `unit_full_depth`, and the `asset_id` and `asset_name` it is - or its own `unit_device` name and `unit_type`.

**A rack** takes `client_id`, `rack_name`, `rack_type` - one of your [rack types](/admin/categories-and-tags) - and `rack_units`, how tall it is (1 to 70), all required to create one. Then `rack_units_descending` (`1` when U1 is at the top), `rack_model`, `rack_depth`, `rack_power_capacity` (watts), `rack_location_id` (one of the client's locations), `rack_physical_location`, `rack_description` and `rack_notes`. Update takes `rack_id` and changes only what you send - a rack can't be made shorter than the highest item in it. Delete needs **Full** on Support and the rack archived first; what's in it goes with it, and its assets stay. Photos are added in ITFlow.

**An item** takes `rack_id` to create, `unit_id` to update or delete, and:

| Field | Notes |
|---|---|
| `asset_id` | One of the client's assets - in one rack at a time |
| `unit_device` | A name, for an item that isn't an asset |
| `unit_type` | Without an asset: `Device` (the default), `Patch Panel`, `Cable Management`, `Shelf`, `PDU`, `UPS`, `KVM / Console` or `Blanking Panel` |
| `unit_start_number` | Required: the lowest unit it takes |
| `unit_height` | How many units. 1 if you leave it out. |
| `unit_face` | `front` (the default) or `rear` |
| `unit_full_depth` | `1` when it takes the front and the rear |
| `unit_power_watts`, `unit_notes` | |

It has to fit the rack, with nothing else on that face. Update changes only what you send. Delete needs **Full** on Support. Each takes `client_id`, the rack's client.

```json
{ "api_key": "YOUR_API_KEY", "rack_id": 1, "asset_id": 12, "unit_start_number": 10, "unit_height": 2 }
```

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
| POST `software/create.php` | Adds a license |
| POST `software/update.php` | Changes a license |
| POST `software/archive.php` | Archives a license |
| POST `software/unarchive.php` | Brings an archived license back |
| POST `software/delete.php` | Deletes an archived license |
| POST `software/seats.php` | Sets who holds a seat |
| POST `software/renew.php` | Renews a license |
| GET `software_keys/read.php` | A license's keys, and who each is handed to |
| POST `software_keys/create.php` | Adds keys |
| POST `software_keys/update.php` | Changes a key, or who it's handed to |
| POST `software_keys/delete.php` | Deletes a key |

### Read {#licenses-read}

| Parameter | Does |
|---|---|
| `software_id` | Just this license |
| `software_key` | The license with this key - its own, or one of its keys |
| `client_id` | Just this client's licenses |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Archived licenses are left out of the list.

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

### Create {#licenses-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `software_name` | Required |
| `software_version`, `software_type`, `software_license_type` | |
| `software_seats` | How many it covers. Leave it out for no limit. |
| `software_purchase`, `software_expire` | When it was bought and when it runs out, as `2026-11-05` |
| `software_purchase_reference` | |
| `software_vendor_id` | One of the client's [vendors](/api/clients#vendors) |
| `software_key` | |
| `software_keys` | Create only: license keys to add, one per line |
| `software_description`, `software_notes` | |
| `software_favorite` | `1` to make it a favourite |

```
curl -X POST https://itflow.example.com/api/v1/software/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "software_name": "Dentrix Ascend", "software_license_type": "Subscription", "software_seats": 12, "software_expire": "2027-06-30"}'
```

### Update, archive, unarchive and delete {#licenses-update}

Each takes `software_id` and `client_id`, the license's own client. `update.php` also takes any of the fields under [Create](#licenses-create), and changes only what you send. Only active licenses can be changed. `delete.php` needs **Full** on Support, and the license has to be archived first. Its seats and keys go with it.

### Seats and renewal {#licenses-seats}

**Seats** (`seats.php`) takes `software_id`, `client_id`, and `asset_ids` and `contact_ids` - the client's devices and users that hold a seat, each list in place of the one it had. One you leave out stays as it is. A device or user that loses its seat gives back the keys it was handed. The answer has `added` and `removed`, by name, and `warning` when it's over its seats.

**Renew** (`renew.php`) takes `software_id`, `client_id`, and `renew_term` - `1m`, `3m`, `6m`, `1y`, `2y` or `3y`, from its renewal date, or from today once that has passed - or `renew_date`, the new date. `purchase_reference` records what it was renewed on. The answer has `software_expire`.

### Keys {#license-keys}

Read takes `software_id` or `software_key_id`. Each key has the `assets` and `contacts` it's handed to.

- **Create** takes `software_id` and `keys`: one per line, or a list. Blank ones and keys it has already are skipped. The answer has `added`.
- **Update** takes `software_key_id`, and any of `software_key`, `asset_ids` and `contact_ids` - who it's handed to, in place of those it had. Each gets a seat if it had none. The answer has `warning`, as for seats.
- **Delete** takes `software_key_id` and needs **Full** on Support. Its seats stay.

Each takes `client_id`, the license's client.

## Domains {#domains}

| Endpoint | Does |
|---|---|
| GET `domains/read.php` | Lists domains, or finds one by name |
| POST `domains/create.php` | Adds a domain |
| POST `domains/update.php` | Changes a domain |
| POST `domains/archive.php` | Archives a domain |
| POST `domains/unarchive.php` | Brings an archived domain back |
| POST `domains/delete.php` | Deletes an archived domain |

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

### Update, archive, unarchive and delete {#domains-update}

Each takes `domain_id` and `client_id`, the domain's own client. `update.php` also takes any of the fields under [Create](#domains-create), looks the domain up again, and records what changed in the domain's history. Only active domains can be changed. `delete.php` needs **Full** on Support, and the domain has to be archived first. It comes off the services it was on; its certificates stay, on no domain.

## Certificates {#certificates}

| Endpoint | Does |
|---|---|
| GET `certificates/read.php` | Lists certificates, or finds one |
| POST `certificates/create.php` | Adds a certificate |
| POST `certificates/update.php` | Changes a certificate |
| POST `certificates/archive.php` | Archives a certificate |
| POST `certificates/unarchive.php` | Brings an archived certificate back |
| POST `certificates/delete.php` | Deletes an archived certificate |

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

With a host, ITFlow connects to it as the certificate is saved, and records what it serves.

### Update, archive, unarchive and delete {#certificates-update}

Each takes `certificate_id` and `client_id`, the certificate's own client. `update.php` also takes any of the fields under [Create](#certificates-create), and changes only what you send - a PEM still has the last word on the issuer, dates and names. A new host is connected to as it is saved. Only active certificates can be changed, and what changed goes in the certificate's history. `delete.php` needs **Full** on Support, and the certificate has to be archived first. Its history and its links to services go with it.

## Services {#services}

| Endpoint | Does |
|---|---|
| GET `services/read.php` | Lists a client's services, or those due a review |
| POST `services/create.php` | Adds a service |
| POST `services/update.php` | Changes a service |
| POST `services/archive.php` | Archives a service |
| POST `services/unarchive.php` | Brings an archived service back |
| POST `services/delete.php` | Deletes an archived service |

### Read {#services-read}

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

### Create {#services-create}

| Field | Notes |
|---|---|
| `client_id` | Required |
| `service_name` | Required |
| `service_importance` | `High`, `Medium` (the default) or `Low` |
| `service_category` | Such as Email, Backup or Line of business |
| `service_description`, `service_backup`, `service_notes` | `service_backup` is how it's backed up |
| `service_review_interval` | How often it's reviewed, in months: `1`, `3`, `6`, `12` or `24`. `0`, the default, is no schedule. |
| `service_review_due` | Its next review, as `2026-11-05`. With an interval and no date, it's worked out from today. |

What it runs on and depends on is linked in ITFlow, on the service's page.

### Update, archive, unarchive and delete {#services-update}

Each takes `service_id` and `client_id`, the service's own client. `update.php` also takes any of the fields under [Create](#services-create), and changes only what you send. Only active services can be changed. `delete.php` needs **Full** on Support, and the service has to be archived first. Its links and tags go with it.

## Documents {#documents}

| Endpoint | Does |
|---|---|
| GET `documents/read.php` | Lists documents, or gets one |
| POST `documents/create.php` | Adds a document |
| POST `documents/update.php` | Changes a document, keeping the version before |
| POST `documents/archive.php` | Archives a document |
| POST `documents/unarchive.php` | Brings an archived document back |
| POST `documents/delete.php` | Deletes an archived document |

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

### Update, archive, unarchive and delete {#documents-update}

Each takes `document_id` and `client_id`, the document's own client. `update.php` also takes any of the fields under [Create](#documents-create). The document as it was is kept in its versions, as when it's edited in ITFlow. `delete.php` needs **Full** on Support, and the document has to be archived first. Its versions and its images go with it.
