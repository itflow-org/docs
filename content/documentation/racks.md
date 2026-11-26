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
5. Add front and rear photos - click **Add a photo** under each (see [Change a picture](/getting-started/account#picture)) - and notes.
6. Click **Create**.

## The rack's page

![A rack drawn front and rear, with a server, a NAS, switches, a firewall, a patch panel, a UPS and a PDU](doc-rack.webp "The elevation: every item at its position, front and rear, in colours by kind")

- Down the side: how many **U** are used and free, the **largest gap** (and where it is), how many items, and the **power** used against the budget. Then what isn't racked yet, the rack's details, notes and history.
- **Elevation** draws the front and the rear. Items are coloured by kind - servers, network, firewalls, power, patching and other. A full-depth item mounted at the front shows as a dashed outline at the rear, so you can see the space it takes.
- **In this rack** lists every item with its position, make, model, serial number, IP address and which side it's mounted on. What's in a [holder](#holders) is listed under it, with its slot.
- **Not racked yet** lists the client's servers, NAS units, network gear, UPSs, PDUs and NVRs that don't have a place in a rack yet. Drag one onto the drawing where it goes, or use **Rack It**.
- The print button gives a clean page of the rack to stick on the cupboard door.

## Put something in the rack

Click an empty U on the drawing, or **Add Item**. Or drag one of the client's assets from **Not racked yet** onto the drawing and let go where it goes - the window opens with the asset, the U and the side filled in.

1. Pick an **Asset** - a server, NAS, switch, UPS or other device the client has - or, under **What is it**, an item that isn't an asset: a patch panel, cable management, a shelf, a PDU, a UPS, a KVM or a blanking panel. An asset starts at its usual size - 2U for a server, NAS or UPS, and half depth for a firewall, access point, modem or PDU - which you can change.
2. Set the **Lowest U** it sits in and its **Height** in U, which side it's **Mounted on** (front or rear), and whether it's **Full depth**.
3. Add its **Power draw** in watts, if you track power, and notes.
4. Save.

Click an item on the drawing to edit it - for an asset, which opens its own page, use the pencil at its right. Every item also has a pencil on its row under **In this rack**. An asset's own page shows which rack it's in and at which U under **Where & who**, with **Edit or remove**.

To take something out of the rack, edit it and click **Remove from rack**. The asset itself stays.

## More than one device in a U {#holders}

Some kit sits side by side: two Tiny PCs in a 1U bracket, a shelf of Raspberry Pis, the cards in a media converter chassis, PLCs stacked on a shelf. Put the bracket, shelf or chassis in the rack as a holder, then put the devices in its slots.

![A 2U shelf with six Raspberry Pis in two rows of four, and a 1U bracket with two Tiny PCs](doc-rack-holder.webp "Holders: devices side by side, wrapping onto another row")

1. Add the holder as you would anything else - an asset, such as a chassis, or a **Shelf** under **What is it** - with its U, height, side and depth.
2. Turn on **Holds devices side by side** and set how many fit **across**. More than that wrap onto another row, so three stacks of three Tiny PCs on a shelf is 3 across.
3. Save.

The holder is drawn with its slots in it. To put something in one:

- Click an empty slot, or drag an asset from **Not racked yet** onto it, and save.
- Or, when you add an item, pick the holder under **Goes in**, then the **Slot**. Slot 1 is at the bottom left, counting across and then up a row - or from the top left, down a row, when U1 is at the top.
- Drag an item that's already in the rack onto an empty slot to put it in the holder.

A device in a holder takes the holder's U, side and depth. Drag it to another empty slot to move it - the message has [Undo](/getting-started/lists#undo). To take it out of the holder, edit it and pick **The rack** under **Goes in**. The holder itself is the tab at its left: click it to edit the holder, or drag it to move the holder with everything in it.

A device's own page shows its slot under **Where & who**, with a link to the holder when the holder is an asset. A holder that's an asset has **Devices in it** on its page, listing what's in each slot.

Removing a holder takes the devices in it out of the rack too - ITFlow asks first, and the assets themselves stay. A holder can't go in another holder, and while it has devices in it, **Holds devices side by side** stays on.

### Multi-node servers and blade chassis {#chassis}

A multi-node server - a 2U box with four server nodes, such as a Supermicro BigTwin - or a blade chassis is a holder too. The chassis is one asset, with the system's serial number and warranty, and each node or blade is an asset of its own, with its own serial, management IP, operating system and RMM agent.

1. Add the chassis as an asset - a **Server**, or a type of your own such as **Chassis** made in [Asset Types](/admin/asset-types) - and rack it with its height and **Full depth** on. When the nodes slide in from the back, mount it on the **Rear**, so the slots are drawn on the side you see them from.
2. Turn on **Holds devices side by side** with how many nodes sit side by side - 2 across for a 2U four-node server gives two rows of two.
3. Add each node as a **Server** asset and drag it from **Not racked yet** into the slot it sits in.

Name the nodes by the letter or number on the chassis - RDG-BT-01-A, RDG-BT-01-B - as the maker's order may not match ITFlow's slot numbers. Put the power draw on the chassis, not the nodes, so it isn't counted twice.

![A chassis asset's page: its rack position, and Devices in it listing its four nodes by slot](doc-asset-chassis.webp "A chassis's page lists its nodes")

## Move something {#move}

Drag an item on the drawing to where it should go, front or rear, and let go. It keeps its height and depth. While you drag, the rack shows where it would land - in red, with what's there, when something is in the way. The U you hold it by is the one that lands where you let go - hold a 2U server by its bottom half to place its bottom U. The message after has [Undo](/getting-started/lists#undo), which puts it back - if that place is still free.

![A 2U NAS being dragged down to U3-U4 on the front of the rack](doc-rack-drag.webp "Dragging an item: where it would land, at U3-U4")

To change its height or depth, or which side it's mounted on without moving it, edit it instead.
