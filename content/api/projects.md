---
title: Projects
description: API reference for projects - starting them, with a project template's tickets, changing, completing, archiving and deleting them, and putting tickets on them.
---

These endpoints need the **Support** area of the key's role, as [projects](/service-desk/projects) do in ITFlow. Making and changing needs **Modify**, and deleting **Full**. See [Keys and permissions](/api/permissions).

A project with no client (`project_client_id` `0`) is internal work. A key whose agent can see only some clients can read internal projects, but not change them.

## Projects {#projects}

| Endpoint | Does |
|---|---|
| GET `projects/read.php` | Lists projects, or gets one with its tickets and progress |
| POST `projects/create.php` | Starts a project, with a project template's tickets if you like |
| POST `projects/update.php` | Changes a project |
| POST `projects/apply_template.php` | Raises a project template's tickets on a project |
| POST `projects/complete.php` | Marks a project complete |
| POST `projects/reopen.php` | Reopens a completed project |
| POST `projects/archive.php` | Archives a project |
| POST `projects/unarchive.php` | Brings an archived project back |
| POST `projects/delete.php` | Deletes an archived project |

### Read {#projects-read}

| Parameter | Does |
|---|---|
| `project_id` | Just this project, with its tickets and progress |
| `client_id` | Just this client's projects. `0` for internal ones. |
| `limit`, `offset` | [Paging](/api/requests#paging) |

Open, completed and archived projects are all listed - `project_completed_at` and `project_archived_at` tell them apart. Each has its `project_reference`, the number people see.

With `project_id`, the project also has `tickets` - its tickets of the clients the key's agent can see, with their status - and `stats`, its progress as on its page:

| Field | Notes |
|---|---|
| `tickets`, `open`, `done`, `overdue` | How many tickets it has, how many are open and done, and how many open ones are past due |
| `tasks`, `tasks_done` | The tasks on its tickets, and how many are done |
| `seconds`, `billable_seconds`, `unbilled_seconds` | The time logged on its tickets - all of it, the billable part, and what of that isn't invoiced yet - in seconds |
| `last_activity` | When one of its tickets last changed |

```json
{
  "success": "True",
  "count": 1,
  "data": [
    {
      "project_id": "3",
      "project_reference": "PRJ-3",
      "project_name": "Imaging server replacement",
      "project_start": "2026-10-19",
      "project_due": "2026-11-27",
      "project_budget_hours": "16.00",
      "project_manager": "1",
      "project_contact_id": "2",
      "project_completed_at": null,
      "project_archived_at": null,
      "project_client_id": "1",
      "tickets": [
        { "ticket_id": "93", "ticket_prefix": "TCK-", "ticket_number": "93", "ticket_subject": "Site internet dropping intermittently", "ticket_status": "2", "ticket_status_name": "Open", "ticket_priority": "High", "ticket_assigned_to": "1", "ticket_due_at": null, "ticket_resolved_at": null, "ticket_closed_at": null, "ticket_client_id": "1" }
      ],
      "stats": { "tickets": 2, "open": 2, "done": 0, "overdue": 0, "tasks": 7, "tasks_done": 2, "seconds": 4500, "billable_seconds": 4500, "unbilled_seconds": 4500, "last_activity": "2026-11-13 22:26:20" }
    }
  ]
}
```

**Fields:** `project_id`, `project_prefix`, `project_number`, `project_reference`, `project_name`, `project_description`, `project_start`, `project_due`, `project_budget_hours`, `project_manager`, `project_contact_id`, `project_created_at`, `project_updated_at`, `project_completed_at`, `project_archived_at`, `project_client_id`.

### Create {#projects-create}

| Field | Notes |
|---|---|
| `project_name` | Required |
| `client_id` | The client. Leave it out for internal work. |
| `project_description` | Its scope - what it's for and what's included |
| `project_start`, `project_due` | Dates, as `2026-11-05`. The due date can't be before the start. |
| `project_budget_hours` | The hours sold for it |
| `project_manager` | An active agent's `technician_id`. They're told, unless it's the key's own agent. |
| `project_contact_id` | The client contact who signs it off - one of the client's |
| `project_template_id` | A [project template](/admin/ticket-templates) whose tickets to raise on it, in order |
| `assign_to_manager` | `1` gives the template's tickets to the manager. Otherwise each goes to its ticket template's agent. |

It gets the next project number, as New Project gives it. A template's tickets are each set up as their ticket template says - category, priority, billing, agent, due time, tags and tasks - for the project's contact. The client isn't emailed about them. The answer has `project_reference` and `tickets_raised`.

```
curl -X POST https://itflow.example.com/api/v1/projects/create.php \
  -H "Content-Type: application/json" \
  -d '{"api_key": "YOUR_API_KEY", "client_id": 1, "project_name": "Phone system cutover", "project_start": "2026-11-16", "project_due": "2026-12-18", "project_budget_hours": 24, "project_manager": 2, "project_template_id": 1, "assign_to_manager": 1}'
```

```json
{ "project_reference": "PRJ-42", "tickets_raised": 2, "success": "True", "count": "1", "data": [ { "insert_id": 42 } ] }
```

A name left out, a date that isn't one, or a manager, contact, client or template that won't do is refused with `400` and why in `message`.

### Update {#projects-update}

`update.php` takes `project_id`, `client_id` - the project's own client, needed when the key's agent can see only some clients - and any of the fields under [Create](#projects-create) apart from the client and template. Only what you send changes. Send an empty `project_start`, `project_due` or `project_budget_hours` to clear it. A new manager is told. An archived project can't be changed - unarchive it first.

### Tickets on a project {#projects-tickets}

A ticket goes on a project with `ticket_project_id` on [tickets/create.php](/api/tickets#tickets-create) or [tickets/update.php](/api/tickets#tickets-update), and comes off with `0`. The project has to be the ticket's client's, or an internal one.

**Apply a template** (`apply_template.php`) raises a project template's tickets on an open project, as **Add tickets** does on its page. It takes `project_id`, `client_id`, `project_template_id` and `assign_to_manager` - `1` gives them to the project's manager. The answer has `tickets_raised`.

### Complete, reopen, archive and delete {#projects-complete}

Each takes `project_id` and `client_id`.

- **Complete** marks it complete - only once none of its tickets is open. Otherwise the answer says how many are.
- **Reopen** brings a completed project back. An archived one has to be unarchived first.
- **Archive** moves it to Archived. Its tickets stay as they are. **Unarchive** brings it back, open again or completed if it was.
- **Delete** needs **Full** on Support, and the project has to be archived first. Its tickets stay, no longer part of a project.
