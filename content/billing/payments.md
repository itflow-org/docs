---
title: Taking payments
description: Record a check or bank transfer against an invoice, spread one payment over several invoices, charge a saved card, and let clients pay online.
where: Billing > Invoices > an invoice > Add Payment
---

A payment marks an invoice paid - in full, or in part - and puts the money in one of your accounts, so your books and the client's balance stay right. Payments come in three ways:

- you **record** one that came in by check, bank transfer or cash
- the client **pays online** by card, from the invoice's link or the client portal, and it's recorded for you
- you **charge a card** the client saved, or a recurring invoice does it by itself with autopay

## Record a payment

1. Open the invoice and click **Add Payment** - or use **Add** on its **Payments** card, or **Add Payment** in its row's menu in the invoices list.
2. **Amount** starts at what's owed. Change it for a part payment - the line under it says whether it pays the invoice in full.
3. Set the **Date** it came in, the **Method** (check, bank transfer and so on) and a **Reference** such as the check or transaction number.
4. Pick the account it went **Into**.
5. Leave **Email a receipt** on to send the client a receipt.
6. Click **Add Payment**.

![The Add Payment window](bill-add-payment.webp "Add Payment: how much, when, how it was paid and which account it went into")

A part payment leaves the invoice **Partial**, with what's still owed. When the balance reaches nothing, it's **Paid**.

## One payment for several invoices

When a client sends one check for several invoices, record it once. In the client's **Invoices**, use the arrow beside **New Invoice** and pick **Batch Payment**.

![The Batch Payment window](bill-batch-payment.webp "Batch Payment: one payment spread over the client's unpaid invoices, oldest first")

It lists the client's unpaid invoices. The payment is spread over them oldest first: each is paid in full until the payment runs out, and the last one it reaches may be part paid.

## Online payments

When your admin has connected a payment provider such as Stripe in **Admin > Payment providers**, invoices get a **Pay Now** button - on the invoice's link and in the client portal. The client pays by card - in the portal they can pay several invoices in one go - and:

- the payment is recorded on the invoice, into the account your admin picked
- the client gets a receipt
- the provider's fee is recorded as an expense overnight, so your income and costs both add up
- an email goes to whoever your admin set to hear about invoices paid online

Your admin can limit online payment to invoices under a set amount.

### Saved cards and autopay

A client can save a card in the client portal. Then:

- on a sent invoice, the arrow beside **Add Payment** has **Charge Saved Card**. The card is charged straight away, the payment is recorded and a receipt goes to the client.
- a [recurring invoice](/billing/recurring-invoices#autopay) can charge the card by itself on the due date of each invoice it makes.

![The Charge Saved Card window](bill-charge-card.webp "Charge Saved Card: the card is charged at once and the payment recorded")

## Change or remove a payment

Each payment is listed on the invoice's **Payments** card. Its **⋮** menu has **Edit** and **Delete**. Deleting a payment takes it off the invoice and its account, so the invoice is owed again - no money moves.

Every payment, and income that isn't for an invoice, is also listed in **Finance > Income**. Click one for its quick look, with **Open Invoice**, **Email Receipt**, **Edit** and **Delete**.

![A payment's quick look](bill-payment-ql.webp "A payment's quick look: the invoice it paid, what's still owed, and where the money went")

The quick look also says whether the payment has cleared on a bank statement, once you [reconcile](/finance/reconciling) the account.

> [!NOTE]
> The payment methods in the **Method** list, and the accounts, are set up by your admin in **Admin > Payment methods** and **Finance > Accounts**.
