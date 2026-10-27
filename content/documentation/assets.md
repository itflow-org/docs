---
title: Assets
description: Every device you look after - computers, servers, NAS units, switches, firewalls, UPSs, printers, phones - with its hardware, the details its kind has, network details, warranty, who has it and where it is.
where: Clients > a client > Assets
---

An asset is a device: a laptop, a server, a NAS, a switch, a firewall, a UPS, a printer. Its record holds what it is, where it is, who uses it, how to reach it on the network, when it was bought and when its warranty runs out, and the details only its kind of device has - a switch's ports, a UPS's battery, the host a virtual machine runs on - and links it to its tickets, logins, licenses and documents.

## The assets list

![A client's assets list](gs-list.webp "Assets: type tabs, filters, and each device's type, model, IP address, who has it and where it is")

- **Tabs** split the list by type - **Workstations**, **Servers & NAS**, **Virtual**, **Network**, **Power** (UPSs and PDUs), **Printers** and **Other** - each with a count. **New** on a tab starts that kind of asset.
- **Filters**: location, status, tags and warranty. **More columns** adds columns to the list - **Details** shows each device's own details, such as a switch's ports or an access point's Wi-Fi.
- Each row shows the device's type icon, name and description, its tags, type and operating system, make, model and serial number, IP address, who it's assigned to, its location and its status. A UPS whose battery is due for replacing soon, or overdue, has a badge by its model.
- **Web**, **SSH** and **RDP** buttons beside an IP address open a connection to the device - the browser for Web, your SSH or remote desktop app for the others.
- The location, assigned contact and status can be changed right in the row.

To see every client's devices together, use **All Client Docs > Assets**.

## Add an asset

1. Open the client, go to **Assets** and click **New Asset**.
2. On **Details**, pick the **Type** (desktop, laptop, server, NAS, virtual machine, firewall, switch, access point, modem, UPS, PDU, printer and so on), give it a **Name** and **Status**, and fill in the **Make**, **Model**, **Serial number** and **Operating system** or **Firmware**, and the type's own details (see [Details by type](#details-by-type)). Click the star to make it a favorite, which puts it on the client's overview.
3. On **Assignment**, pick its **Location**, **Where in the building** it is (a room, a cupboard), and who it's **Assigned to**.
4. On **Network**, enter its **IPv4 address** (or switch on **DHCP**), **MAC address**, and any NAT or IPv6 address. **Link** is the address you open it at, such as its management page. A **Client link** shows in the client portal.
5. On **Purchase**, pick the **Vendor**, the **Order / invoice reference**, and when it was **Purchased** and **Installed**, and when its **Warranty expires**.
6. On **Login**, add a username and password for it, which become a credential linked to it.
7. On **Notes**, add notes and a photo.
8. Click **Create**.

![The New Asset window on its Details tab](doc-asset-form.webp "New Asset: Details, Assignment, Network, Purchase, Login and Notes")

The form only asks for what the type has. A virtual machine has no serial number, purchase or warranty, a mobile phone or tablet no network, a display no operating system, and only computers, phones, tablets and displays are assigned to someone - **Other** asks for everything. A field the type doesn't ask for still shows if it already holds something, so nothing is lost when you change an asset's type. The examples in the fields change with the type, too.

**Copy**, in an asset's menu, starts a new asset from it - handy for a batch of identical laptops. It brings the details along, but not those that belong to the one device: an IMEI, phone number, extension, circuit ID or ISP account. To bring in many at once, use **Import** in the New Asset menu with a CSV spreadsheet. After the usual twelve columns it can take any of the details, headed as the asset export heads them - `Ports`, `RAM (GB)`, `Capacity (VA)`, `Host` and so on.

> [!TIP]
> Hardware you sell on an invoice can become the client's assets straight from the invoice, with **Add to Assets**. See [Products and stock](/billing/products#hardware-becomes-client-assets).

## Details by type

Under **Details**, the form has a section of what only that kind of device has:

| Type | Its details |
|---|---|
| Laptop, desktop, server | CPU, RAM, storage |
| Virtual machine | The host it runs on - one of the client's servers or NAS units - vCPUs, RAM, storage |
| NAS | Drive bays, drives, raw and usable capacity, RAID, ports |
| Firewall/router | Ports, SFP ports |
| Switch | Ports, SFP ports, PoE budget, managed or not |
| Access point | Wi-Fi standard |
| Modem/ONT | Circuit ID, ISP account, ports |
| UPS | Capacity (VA), output (W), runtime, outlets, when the battery went in and when to replace it by |
| PDU | Basic, metered, monitored or switched, outlets, input |
| Printer | Colour or black and white, supplies |
| Phone | Extension |
| Mobile phone, tablet | Number, carrier, IMEI |
| Display | Size, resolution |
| Camera | Resolution |
| NVR/DVR | Channels, storage, ports |

![The New Asset window for a switch, with its ports, SFP ports, PoE budget and management](doc-asset-details.webp "A switch's details: give it its ports and its interfaces are made")

A value a detail can't take - a word where a number goes, a date that doesn't exist - isn't kept, and the message after saving says which and why.

**Ports** and **SFP ports** make the device's network interfaces. Save a switch with 24 ports and 4 SFP ports and it gets the interfaces it doesn't have yet - ports 02 to 24 after its primary 01, then SFP 1 to 4 - carrying on from any ports it already has. A new count adds the ones missing; a lower one takes none away, and saving the asset again with the same counts adds nothing back. Wi-Fi, VLAN and other virtual interfaces don't count as ports, and neither does a management port such as mgmt0 or iDRAC. On an asset that has interfaces already, the form says how many it has now.

![The Network tab of the assets list with its Details column](doc-assets-network.webp "Details in the list: Wi-Fi standards, port counts, a modem's circuit ID")

## The asset's page

![A server's page with its Network, Hardware and Where & who cards and an Interfaces tab](doc-asset.webp "An asset's page: the device at a glance - here a server, with its CPU, RAM and the VMs it runs - with everything linked to it in tabs")

Along the top are the asset's photo or type icon, name, status, type, model and tags, with:

- **Web** (and **SSH** or **RDP**) to connect to it
- **New** - a ticket, recurring ticket, credential, interface, license, document, file or note for it
- **Link** - link a service, file or other record that already exists
- **Edit**, and **⋮** for **Copy** and **Archive**

The cards show its **Network** details, its **Hardware** - model, serial, operating system or firmware, its details, warranty, when it was bought and installed, the vendor and order reference - and **Where & who**: its location, rack position and who has it. **Quick notes** save as you click away.

A server or NAS lists the virtual machines that run on it, under **Runs**, and a virtual machine links to its host. A UPS shows how long is left until its battery is to be replaced:

![A UPS's page, with its capacity, runtime and the battery due for replacing in 24 days](doc-asset-ups.webp "A UPS: its capacity, output, runtime and outlets, and when the battery went in and is due out")

The tabs list its **Interfaces**, **Credentials**, **Tickets**, **Recurring** tickets, **Licenses**, **Documents**, **Files**, **Services**, **Notes** and **History**.

## Network interfaces

An interface is one of a device's network ports or connections: a server's management port, a firewall's WAN port, port 12 on a switch. Each can have its own address on one of the client's networks, its VLANs, and what it's plugged into.

To add one, open the asset and click **New > Interface** (or **New Interface** on the Interfaces tab):

1. On **Details**, type its **Name or port** (eth0, Gi1/0/1, WAN), tick **Primary** if it's the device's main address, and set its **Type** and **VLANs** - a single VLAN, or a trunk such as `Trunk 1, 10-20`.
2. On **Address**, pick its network and address. ITFlow checks the address is in the network, warns if another device has it, and can fill in the next free one.
3. On **Connected to**, pick the device and port it's plugged into - port 12 on the switch, say. The other end is linked too.
4. Click **Create**.

![The New interface window](doc-interface-form.webp "A new interface: its port, type and VLANs, then its address and what it's plugged into")

### Port maps

Switches, firewalls, access points, modems, NAS units and NVRs show their interfaces as a **port map**: a grid of ports, coloured by whether each is connected, has an address, or is free, with the SFP cages on a row of their own. Click a port to see or change it. The list view beside it shows the same ports as a table.

![A switch's page with its port map](doc-switch.webp "A 24-port switch with two SFP cages: which ports are connected and which are free")

To set up a whole switch at once, give it its **Ports** and **SFP ports** on the asset form (see [Details by type](#details-by-type)), or use **Add a run of ports** in the New Interface menu - ports 1 to 48, say. Interfaces can also be imported and exported with their VLANs and connections, and the bulk actions on the Interfaces tab set the network, VLANs or type for many ports, set them to DHCP, or disconnect them.

## Status, warranty and lifecycle

An asset's **Status** - Ready to Deploy, Deployed, Out for Repair, Lost, Stolen, Retired, and any others your admin adds - says where it is in its life. Lost, stolen and retired devices are left out of counts such as per-device billing.

Warranties coming up for renewal show on the client's overview, the dashboard and in [Reports](/finance/reports) (Asset Lifecycle and Renewals & Expirations).

A UPS's **Replace battery by** date is watched the same way: its page says how long is left, the list shows a badge by its model as the date nears or passes, and agents are notified 45, 7 and 1 days before.

## Archive and move

**Archive** (in the asset's menu, or **Bulk Action**) takes a device you no longer look after out of the lists, keeping its history. **Transfer to Client**, in Bulk Action, moves assets to another client - when a device moves between companies you both look after. Their interfaces and details go with them, apart from a virtual machine's host, which stays with the old client.
