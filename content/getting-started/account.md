---
title: Your account
description: Your name, picture and email signature, your password and multi-factor sign-in, how ITFlow looks for you, and a record of everything you've done.
where: Your name > Account
---

Click your name in the top bar and pick **Account**. Your account has its own menu: **Profile**, **Security**, **Preferences**, **Canned Responses** and **Activity**.

## Profile

![Your profile: picture, name, email, role and signature](gs-account-profile.webp "Profile: your picture, name, email and the signature added to your ticket replies")

- **Picture** - click it to change it (see below). Without one, ITFlow shows your initials in a colour of their own, the same everywhere you appear.
- **Name** and **Email** - the email is also what you sign in with.
- **Signature** - added to the end of your ticket replies and the emails they send.
- **Role** - what you can open in ITFlow. Only an administrator can change it.

Click **Save** when you're done.

### Change a picture {#picture}

Pictures - yours, a user's or a contact's, the photos of assets, locations and racks, an expense's receipt and your company's logo - show on their form as the picture itself, with a camera on it: the person's initials, or a camera and **Add a photo**, when there isn't one yet. Click it to open the **Picture** window.

1. Drop a picture on the window, paste one, or click **Choose a picture**. It can be a JPG, PNG, GIF or WebP.
2. Crop it to fit. It sits in a frame the shape it's shown in - a circle for a person. Drag it into place, and scroll, pinch or use the slider to zoom; on the keyboard the arrow keys move it and **+** and **-** zoom. The arrow button turns it a quarter, and the one beside it fits it again. A photo of an asset, location or rack can also be **Square**, **4:3**, **3:4** or **Whole**. A receipt or a logo has no set shape: drag the corners and edges of the frame in to just what you want, and drag inside it to move it. For a logo, **Trim the edges** cuts away the empty or plain-coloured space round it.
3. Click **Use this picture**, then save the form. On an expense's quick look, a receipt is saved straight away.

![The Picture window, cropping a contact's photo to a circle](gs-picture.webp "The Picture window: drag the picture into the frame and zoom - what's in the frame is what's kept")

**Remove** takes the picture off when you save the form. Clicking the picture again opens the one you picked, as you left it, to change.

What's kept is what's in the frame, at up to 512 pixels across for a person, 2048 for a photo, 2400 for a receipt and 1200 for a logo - so a big phone photo goes in at a sensible size, the right way up, and without its location or camera details. A logo's see-through background stays see-through. A receipt can also be a PDF, which goes in as it is.

## Security

### Change your password

1. Go to **Account > Security**.
2. Type your **Current password**, then the **New password** twice. It must be at least 8 characters.
3. Click **Change password**. You're signed out, so you can sign in again with the new one.

### Turn on multi-factor authentication (MFA)

With MFA on, signing in takes your password and a 6-digit code from an app on your phone, so a stolen password alone doesn't get anyone in. Your administrator may require it - in that case ITFlow asks you to set it up when you sign in.

1. Go to **Account > Security** and click **Turn on MFA**.
2. Open your authenticator app - Microsoft or Google Authenticator, 1Password, Authy, Bitwarden - and add an account.
3. Scan the QR code. If you can't scan it, type the secret shown under it into the app instead.
4. Type the 6-digit code the app shows, and click **Turn on**.

![The window for turning on MFA, with a QR code to scan and a box for the code](gs-account-mfa.webp "Scan the code with your authenticator app, then type the code it shows")

When you sign in with your code, tick **Remember this browser** and ITFlow doesn't ask for a code in that browser again for a while (your admin sets how long). **Remembered browsers**, on the same page, lists them. Click **Forget** beside one, or **Forget all**, and the code is asked for again there - do this if you lose a laptop or sign in on a shared computer.

> [!NOTE]
> Got a new phone? If you can turn MFA off yourself, turn it off and on again with the new phone. If your administrator requires MFA, ask them to reset it - you set it up again at your next sign in.

![The Security page: password, multi-factor authentication and remembered browsers](gs-account-security.webp "Security: your password, MFA and the browsers that skip the code")

## Preferences {#preferences}

![Preferences: theme, the first day of the week, rows on a list and your calendar colour](gs-account-preferences.webp "Preferences")

- **Theme** - **Light** or **Dark**.
- **Calendars start on** - the first day of the week on the calendar and date pickers.
- **Rows on a list** - how many rows every list shows on a page. You can also change this at the foot of any list.
- **Calendar color** - the colour your booked tickets and the events assigned to you are drawn in on the [calendar](/service-desk/calendar#colours). Click one of the twelve, or the box to pick any colour. **Automatic** goes back to the one you started with.

## Your canned responses

**Canned Responses** in your account lists the canned responses you keep for yourself, alongside the shared ones, with how often you've used each. See [Canned responses](/service-desk/canned-responses).

## Activity

**Activity** is everything you've done in ITFlow: changes, deletions, sign-ins, and data that went out (passwords you looked at, exports and downloads). Search it, pick a date range, or use the tabs to see one kind.

![Your activity, with tabs for changes, deletions, sign-ins and data out](gs-account-activity.webp "Activity: what you did, when, for which client and from where")

Each sign-in shows the IP address and the browser and system it came from. A sign-in from an IP address your account hasn't used before is marked **New IP**.

> [!WARNING]
> If you see a sign-in that wasn't you, change your password straight away, turn on MFA if it isn't on, and tell your administrator.
