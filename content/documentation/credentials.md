---
title: Credentials
description: The logins you keep for clients - usernames, passwords, 2FA codes and where each one opens - kept encrypted, with every look recorded.
where: Clients > a client > Credentials
---

Credentials are the logins you hold for a client: the firewall admin, the Microsoft 365 global admin, the backup console, a supplier's portal. ITFlow stores them encrypted, shows a password only when you ask for it, and records every time someone looks.

## The credentials list

![A client's credentials, with logins, what each is for and when the password last changed](doc-credentials.webp "Credentials: the login, what it's for, and how old the password is")

- **Tabs**: **Starred**, **With 2FA**, **No 2FA**, **Not changed in 90 days**, **Reused password** (see [Reused passwords](#reused)) and **Shared** (logins you've sent as a [shared link](/documentation/shared-links)).
- **Login** shows the username with a copy button, the password as dots - click the eye to show it, or copy it without showing it - and where it opens, as a link.
- **2FA** fetches the current 6-digit code when you click it, so you can sign in without a phone.
- **For** shows the device, vendor, service or license the login is for.
- **Changed** shows how old the password is - green when recent, amber, then red when it's due for a change - and when it was last used.

To see every client's credentials, use **Across Clients > Credentials** in the top bar.

## Add a credential

1. Open the client, go to **Credentials** and click **New Credential**.
2. On **Login**:
   - Give it a **Name**, such as "Firewall Administrator". Click the star to make it a favorite.
   - Type the **Username / ID**.
   - Type the **Password / key**, or click the generator to make one - a passphrase or a random password. The strength meter shows how strong it is.
   - Paste the **2FA secret** if it has one. It takes the secret with or without spaces, or the whole `otpauth://` link from the setup QR code, and shows the current code so you can check it's right. It's kept encrypted, as the username and password are.
   - **Opens at** is the address you sign in at. **Also at** is a second address.
3. On **Belongs to**, link the **Asset** or **Contact** it's for.
4. On **Details**, add a **Description** and **Tags** - such as Break Glass, Local Admin or Rotate Quarterly.
5. On **Notes**, add anything else.
6. Click **Create**.

![The New Credential window](doc-credential-form.webp "New Credential: the login, what it belongs to, and notes")

To link a login to a vendor, service or license, use **Link** on that record's page or the credential's quick look.

To add many at once - from another password manager's export, say - use **Import**, under the arrow beside **New Credential**, with a CSV spreadsheet. See [Importing from a spreadsheet](/getting-started/importing).

## Look at a password

Click a credential to open its quick look, with the username, the password (hidden until you click the eye), where it opens, its 2FA code, what it's for and its notes.

![The quick look for a firewall login](gs-quicklook.webp "A credential's quick look")

> [!NOTE]
> Every time a password is shown or copied, it's recorded in the audit log under **Data out**. Your admin can see who looked at which password, and when.

## Change a password

When you change a password on the system itself, record it in ITFlow with **Change Password** (in the row's menu or the quick look) - it's quicker than editing the whole credential. It saves the new password, dates the change so the credential's age starts again, and notes it in the credential's history. A new password typed in **Edit** is dated the same way. Either way, the password it replaces is kept - see [Earlier passwords](#earlier).

Passwords not changed in 90 days show on the client's overview and on the **Not changed in 90 days** tab. **Rotation Report**, in the New Credential menu, shows every client's passwords by age.

### Earlier passwords {#earlier}

When a password is changed - with **Change Password**, **Edit**, an import or the API - the one it had is kept, still encrypted. **Earlier passwords**, in the credential's quick look, lists them newest first, with when each was in use and who changed it.

![A credential's quick look with the Reused password warning and an earlier password shown](doc-credential-earlier.webp "Earlier passwords: the one before, shown with the eye, and Put back")

- Click the eye to show one, or copy it without showing it. Each look is recorded, as for the current password.
- **Put back** makes it the password again - for when a change broke something that still used the old one. The password it has now takes its place under Earlier passwords.
- With **Delete** access to credentials, the bin deletes one you don't want kept.

The newest ten are kept for each credential. They go when the credential is deleted.

## Reused passwords {#reused}

The **Reused password** tab picks out the logins whose password another of the same client's logins also has, each marked **Reused** - hover it to see which. A credential's quick look names the others, with a link to each. If one of them leaks, so do the others: give each its own with **Change Password**.

ITFlow compares the passwords as the page opens, using your vault key, and keeps nothing about them. Archived credentials, and logins of different clients, aren't compared.

## Send a login to the client

Never email a password. Use **Share** (in the row's menu or the quick look) to send it as a link that works for a set time, can be opened a set number of times, and can ask for a passphrase or a code first. See [Shared links](/documentation/shared-links).

To get a login *from* the client - their domain registrar, say - use **Ask the Client for a Login** in the New Credential menu. They get a form to fill in, and what they send waits in Shared Links for you to save.
