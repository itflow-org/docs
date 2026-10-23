---
title: Examples
description: Complete PowerShell examples - an RMM alert that raises and resolves a ticket, a caller lookup, an asset sync, a monthly time report and reading a password.
---

Each example starts with your ITFlow's address and a key. Use a key whose agent has the access the example needs - see [Keys and permissions](/api/permissions):

```powershell
$base = 'https://itflow.example.com/api/v1'
$key  = 'YOUR_API_KEY'
```

They were tested with PowerShell 7. Apart from reading a password, they use nothing that's new in PowerShell 7, so they should run in Windows PowerShell 5.1 too.

## An RMM alert raises a ticket {#rmm-alert}

The RMM gives the client's name, the device's serial number and the alert. The script finds the client and the device, and raises a ticket for them. It needs **Modify** on Support, and **Read** on Clients.

```powershell
# The alert, as your RMM gives it
$clientName = 'Ravenwood Dental Group'
$serial     = '7B5BAE8214'
$alert      = 'Disk C: is 94% full'

# The client and the device, by name and serial number
$client = Invoke-RestMethod -Uri "$base/clients/read.php?api_key=$key&client_name=$([uri]::EscapeDataString($clientName))"
if ($client.success -ne 'True') { throw "No client called $clientName" }
$clientId = $client.data[0].client_id

$asset = Invoke-RestMethod -Uri "$base/assets/read.php?api_key=$key&client_id=$clientId&asset_serial=$serial"
$assetId = if ($asset.success -eq 'True') { $asset.data[0].asset_id } else { 0 }

# Raise the ticket
$body = @{
    api_key         = $key
    client_id       = $clientId
    ticket_subject  = "$alert on $($asset.data[0].asset_name)"
    ticket_details  = "Raised by the RMM: $alert"
    ticket_priority = 'High'
    ticket_asset_id = $assetId
} | ConvertTo-Json
$ticket = Invoke-RestMethod -Method Post -Uri "$base/tickets/create.php" -ContentType 'application/json' -Body $body
$ticketId = $ticket.data[0].insert_id
"Raised ticket $ticketId"
```

Keep the ticket's id. When the alert clears, add a note that resolves the ticket:

```powershell
$ticketId = 1880   # saved when the ticket was raised

$body = @{
    api_key       = $key
    ticket_id     = $ticketId
    ticket_reply  = 'The alert cleared: disk C: is back to 71% after the cleanup task ran.'
    ticket_status = 4    # Resolved
} | ConvertTo-Json
$r = Invoke-RestMethod -Method Post -Uri "$base/ticket_replies/create.php" -ContentType 'application/json' -Body $body
if ($r.success -ne 'True') { throw $r.message }
```

The note is from the key's agent, so the ticket's history shows who - or what - resolved it. Add `ticket_reply_time_worked` to log time against it too.

## Who's calling? {#caller}

A phone system can look the caller up and show their name and client. ITFlow keeps phone numbers as digits only, so the script takes out everything else first. It needs **Read** on Clients.

```powershell
$callerId = '+1 (412) 555-0101'
$digits   = $callerId -replace '\D', ''
if ($digits.Length -eq 11 -and $digits.StartsWith('1')) { $digits = $digits.Substring(1) }   # ITFlow keeps the country code apart

$r = Invoke-RestMethod -Uri "$base/contacts/read.php?api_key=$key&contact_phone_or_mobile=$digits"
if ($r.success -eq 'True') {
    $contact = $r.data[0]
    $client  = Invoke-RestMethod -Uri "$base/clients/read.php?api_key=$key&client_id=$($contact.contact_client_id)"
    "$($contact.contact_name), $($contact.contact_title) at $($client.data[0].client_name)"
} else {
    'Unknown caller'
}
```

```
Dana Prescott, Office Manager at Ravenwood Dental Group
```

## Keep assets in step with the RMM {#asset-sync}

For each device the RMM knows about, the script finds the asset by serial number. It updates the asset if ITFlow already has it, and adds it if not. It needs **Modify** on Support.

```powershell
$clientId = 1

# What your RMM knows about each device
$devices = @(
    @{ name = 'RDG-WS-14'; serial = 'H7Q2LM3'; make = 'Dell'; model = 'OptiPlex 7020'; os = 'Windows 11 Pro'; ip = '192.168.10.64'; mac = 'B0:4F:13:2A:9C:11' }
    @{ name = 'RDG-WS-15'; serial = 'H7Q2LM4'; make = 'Dell'; model = 'OptiPlex 7020'; os = 'Windows 11 Pro'; ip = '192.168.10.65'; mac = 'B0:4F:13:2A:9C:12' }
)

foreach ($d in $devices) {
    $fields = @{
        api_key = $key; client_id = $clientId
        asset_name = $d.name; asset_type = 'Desktop'; asset_serial = $d.serial
        asset_make = $d.make; asset_model = $d.model; asset_os = $d.os
        asset_ip = $d.ip; asset_mac = $d.mac
    }
    $found = Invoke-RestMethod -Uri "$base/assets/read.php?api_key=$key&client_id=$clientId&asset_serial=$($d.serial)"
    if ($found.success -eq 'True') {
        $fields.asset_id = $found.data[0].asset_id
        $r = Invoke-RestMethod -Method Post -Uri "$base/assets/update.php" -ContentType 'application/json' -Body ($fields | ConvertTo-Json)
        # An update that changes nothing comes back "False"
        if ($r.success -eq 'True') { "$($d.name): updated" } else { "$($d.name): no changes" }
    } else {
        $r = Invoke-RestMethod -Method Post -Uri "$base/assets/create.php" -ContentType 'application/json' -Body ($fields | ConvertTo-Json)
        "$($d.name): added as asset $($r.data[0].insert_id)"
    }
}
```

```
RDG-WS-14: added as asset 801
RDG-WS-15: added as asset 802
```

It sends the IP and MAC address every time, because an update clears them otherwise - see [Assets](/api/documentation#assets-update).

## Last month's time, by technician {#time-report}

The script saves last month's time to a CSV file, one row per technician per ticket, and totals the hours for each technician. It reads every page - see [Lists and paging](/api/requests#paging). It needs **Read** on Support.

```powershell
$last = (Get-Date).AddMonths(-1)
$rows = @(); $offset = 0
do {
    $r = Invoke-RestMethod -Uri "$base/technicians/time.php?api_key=$key&year=$($last.Year)&month=$($last.Month)&limit=200&offset=$offset"
    if ($r.success -ne 'True') { break }
    $rows += $r.data
    $offset += 200
} while ($r.data.Count -eq 200)

$rows | Export-Csv -NoTypeInformation -Path "time-$($last.ToString('yyyy-MM')).csv"

# Hours per technician
$rows | Group-Object technician | ForEach-Object {
    $hours = ($_.Group | ForEach-Object { $h, $m, $s = $_.time_worked -split ':'; [int]$h + [int]$m / 60 + [int]$s / 3600 } | Measure-Object -Sum).Sum
    '{0,-15} {1,6:N1} h' -f $_.Name, $hours
}
```

```
Alex Morgan       81.0 h
```

## Read a password {#password}

Reading a credential needs the key's decryption password too, sent in a JSON body - see [Credentials](/api/permissions#credentials). It needs **Read** on Credentials, and PowerShell 7.

```powershell
$decryptPassword = 'YOUR_DECRYPTION_PASSWORD'

# PowerShell 7: a GET request with a JSON body
$body = @{ api_key_decrypt_password = $decryptPassword } | ConvertTo-Json
$r = Invoke-RestMethod -Method Get -Uri "$base/credentials/read.php?api_key=$key&credential_id=1" -ContentType 'application/json' -Body $body
if ($r.success -ne 'True') { throw 'Not found' }
$c = $r.data[0]
"$($c.credential_name): $($c.credential_username) / $($c.credential_password)"
```

```
Firewall Administrator: msp-admin / A265CDE06D86CE!aA1
```

In Windows PowerShell 5.1, use `curl.exe` instead, as in [Credentials](/api/documentation#credentials-read).
