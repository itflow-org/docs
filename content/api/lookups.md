---
title: Tags, categories and roles
description: API reference for tags - reading them and setting a record's tags - and for reading categories and roles.
---

## Tags {#tags}

Tags come in twelve kinds, one for each kind of record that can be tagged: `client`, `location`, `contact`, `credential`, `asset`, `vendor`, `domain`, `license`, `service`, `network`, `document` and `ticket`. A tag of one kind can't go on another kind of record.

A tag needs the role area of its kind of record - Support for asset tags, Clients for contact tags, and so on. See [Keys and permissions](/api/permissions#modules).

| Endpoint | Does |
|---|---|
| GET `tags/read.php` | Lists tags, finds one, or gets a record's tags |
| POST `tags/create.php` | Makes a tag - admins only |
| POST `tags/update.php` | Sets a record's tags, or adds or takes some off |

Records that can be tagged also come with their tags when you read them, as a `tags` list.

### Read {#tags-read}

| Parameter | Does |
|---|---|
| `kind` | Just tags of this kind |
| `record_id` | With `kind`, that record's tags, such as `kind=asset&record_id=9` |
| `tag_id` | Just this tag, archived or not, with `tag_record_ids` - the records that have it, of those the key can see |
| `tag_name` | Tags with this name, in any case |
| `archived` | `1` to include archived tags |
| `limit`, `offset` | [Paging](/api/requests#paging) |

With no `kind`, the list has every kind the key's agent can read.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "tag_id": 8, "tag_name": "Key Account", "tag_description": null, "tag_kind": "client", "tag_type": 1, "tag_color": "#ffc107", "tag_icon": "star", "tag_archived_at": null, "tag_record_ids": [1, 2, 3, 4, 12, 13] }
  ]
}
```

`tag_icon` is a [Font Awesome](https://fontawesome.com/icons) icon's name, and `tag_type` is the kind's number, from 1 for `client` to 12 for `ticket`.

### Create {#tags-create}

Only a key whose agent is an admin can make tags, as in [Admin > Tags](/admin/categories-and-tags).

| Field | Notes |
|---|---|
| `kind` | Required |
| `name` | Required. It has to be unique within its kind, in any case. |
| `description` | |
| `color` | `#rrggbb`. The next colour along if you leave it out. |
| `icon` | A Font Awesome icon's name, such as `x-ray`. `tag` if you leave it out. |

```json
{ "api_key": "YOUR_API_KEY", "kind": "asset", "name": "Imaging", "color": "#0d6efd", "icon": "x-ray" }
```

### Set a record's tags {#tags-update}

| Field | Notes |
|---|---|
| `kind` | Required - the kind of record |
| `record_id` | Required - the record's id, such as an `asset_id` |
| `tags` | Required. Tags by id or name, as a list or separated by commas, such as `["Imaging", "Monitored"]` or `"Imaging,Monitored"`. |
| `mode` | `set` - the default - gives the record these tags and no others. `add` adds them, and `remove` takes them off. |
| `client_id` | The record's client. Needed when the key's agent can see only some clients. |

The agent needs to be able to change that kind of record (Modify). A name that isn't a tag of that kind yet becomes a new tag when the agent is an admin, and is skipped otherwise. An archived tag stays on a record that already has it, but can't be newly added.

The response lists the record's tags afterwards, with what changed in `message`:

```
curl -X POST https://itflow.example.com/api/v1/tags/update.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "kind": "asset", "record_id": 9, "tags": ["Imaging"], "mode": "add"}'
```

```json
{
  "success": "True",
  "count": 6,
  "message": "Added tag Imaging",
  "data": [
    { "tag_id": 67, "tag_name": "Backed Up", "tag_kind": "asset", "tag_type": 5, "tag_color": "#001f3f", "tag_icon": "database" },
    { "tag_id": 118, "tag_name": "Imaging", "tag_kind": "asset", "tag_type": 5, "tag_color": "#0d6efd", "tag_icon": "x-ray" }
  ]
}
```

## Categories {#categories}

The categories in [Admin > Categories](/admin/categories-and-tags) are read only through the API.

| Endpoint | Does |
|---|---|
| GET `categories/read.php` | Lists categories, or finds one |

| Parameter | Does |
|---|---|
| `kind` | Just categories of this kind - see below |
| `category_id` | Just this category, archived or not |
| `category_name` | Categories with this name, in any case |
| `archived` | `1` to include archived categories |
| `limit`, `offset` | [Paging](/api/requests#paging) |

| `kind` | Is | Needs |
|---|---|---|
| `Expense` | Expense categories | Financial |
| `Income` | Income categories | Sales or Financial |
| `Referral` | How clients found you | Clients |
| `Ticket` | Ticket categories | Support |
| `asset_status` | Asset statuses | Support |
| `software_type` | License types | Support |
| `network_interface` | Network interface types | Support |
| `rack_type` | Rack types | Support |
| `contact_note_type` | Contact note types | Clients |
| `asset_note_type` | Asset note types | Support |

`kind` can also be the name Admin > Categories shows, such as `Asset Status`, and capitals don't matter. With no `kind`, the list has every kind the key's agent can read.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    { "category_id": 6, "category_name": "Software", "category_description": null, "category_type": "Expense", "category_color": "#add8e6", "category_icon": null, "category_order": 0, "category_archived_at": null, "category_used": 51, "category_used_by": { "expenses": 27, "budget": 24 } }
  ]
}
```

`category_used` is how many records have the category, archived ones too, and `category_used_by` breaks that down by kind of record. Both are `null` for a key whose agent can't see every client.

**Fields:** `category_id`, `category_name`, `category_description`, `category_type`, `category_color`, `category_icon`, `category_order`, `category_created_at`, `category_updated_at`, `category_archived_at`, `category_used`, `category_used_by`.

## Roles {#roles}

| Endpoint | Does |
|---|---|
| GET `roles/read.php` | Lists the roles, or gets one |

| Parameter | Does |
|---|---|
| `role_id` | Just this role, archived or not |
| `archived` | `1` to include archived roles |
| `limit`, `offset` | [Paging](/api/requests#paging) |

A key whose agent is an admin reads every role. Any other key reads only its own agent's role, so an integration can check what it's allowed to do.

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "role_id": 2,
      "role_name": "Technician",
      "role_description": "Built-in - Limited access to technical-focused modules",
      "role_is_admin": 0,
      "role_levels": { "module_client": 2, "module_support": 2, "module_credential": 2, "module_sales": 2, "module_financial": 0, "module_reporting": 0, "module_ai": 1 },
      "role_agents": 2,
      "role_created_at": "2024-09-03 09:00:00",
      "role_updated_at": null,
      "role_archived_at": null
    }
  ]
}
```

`role_levels` gives each area's level: 0 none, 1 Read, 2 Modify and 3 Full. An admin role (`role_is_admin` 1) can do everything, whatever its levels say. `role_agents` is how many active agents have the role.
