---
title: Racks
description: Draw a client's racks to scale, front and rear, with every server, switch, patch panel and UPS in its place, and how much space and power is left.
where: Clients > a client > Racks
---

A rack's page draws it to scale, front and rear, with everything mounted in it. Use it to plan where new kit goes, and so the next person on site knows what's in the cupboard before they open it.

![A client's racks list](doc-racks.webp "Racks: each one drawn small, with how full it is")

## Add a rack

1. Open the client, go to **Racks** and click **New Rack**.
2. Give it a **Name** and **Type** (2-post or 4-post open frame, 4-post enclosed cabinet, wall-mount open or enclosed), its **Height** in U, and whether U1 is at the bottom or the top (**Unit numbering**).
3. Add its **Model**, **Depth**, **Location** and **Where in the building** - the server room, the comms cupboard.
4. Set its **Power budget** in watts, if you want ITFlow to track how much power is used.
5. Add front and rear photos, and notes.
6. Click **Create**.

## The rack's page

![A rack drawn front and rear, with a server, a NAS, switches, a firewall, a patch panel, a UPS and a PDU](doc-rack.webp "The elevation: every item at its position, front and rear, in colours by kind")

- Down the side: how many **U** are used and free, the **largest gap** (and where it is), how many items, and the **power** used against the budget. Then the rack's details, notes and history.
- **Elevation** draws the front and the rear. Items are coloured by kind - servers, network, firewalls, power, patching and other. A full-depth item mounted at the front shows as a dashed outline at the rear, so you can see the space it takes.
- **In this rack** lists every item with its position, make, model, serial number, IP address and which side it's mounted on.
- **Not racked yet** lists the client's servers, NAS units, network gear, UPSs, PDUs and NVRs that don't have a place in a rack yet, with **Rack it** to put one in.
- The print button gives a clean page of the rack to stick on the cupboard door.

## Put something in the rack

Click an empty U on the drawing, or **Add Item**:

1. Pick an **Asset** - a server, NAS, switch, UPS or other device the client has - or, under **What is it**, an item that isn't an asset: a patch panel, cable management, a shelf, a PDU, a UPS, a KVM or a blanking panel. An asset starts at its usual size - 2U for a server, NAS or UPS, and half depth for a firewall, access point, modem or PDU - which you can change.
2. Set the **Lowest U** it sits in and its **Height** in U, which side it's **Mounted on** (front or rear), and whether it's **Full depth**.
3. Add its **Power draw** in watts, if you track power, and notes.
4. Save.

Click an item on the drawing to edit it or move it. An asset's own page shows which rack it's in and at which U.
