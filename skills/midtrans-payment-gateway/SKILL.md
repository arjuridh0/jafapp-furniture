---
name: midtrans-payment-gateway
description: Directs implementation of the Midtrans API, sandbox/production setups, secure signature validation, snap token retrieval, and status mapping for transaction callbacks.
---

# Midtrans Payment Gateway Skill

## Overview
This skill focuses on integrating the Midtrans Payment Gateway into the JAFAPP system. It defines secure setups, token retrieval flow, and webhook callback processing rules.

## Implementation Guidelines

### 1. Credentials and Environment Configuration
- Never commit private keys to version control. Set keys dynamically in the `.env` file:
  - `MIDTRANS_SERVER_KEY`
  - `MIDTRANS_CLIENT_KEY`
  - `MIDTRANS_IS_PRODUCTION` (boolean)
- Configure variables in `config/midtrans.php` and load them in services.

### 2. Transaction Snap Token Generation
- Implement the token generation logic within a dedicated service (e.g. `app/Services/MidtransService.php`).
- Pass detailed customer and item structures to Midtrans to ensure accurate transaction receipts:
  - `transaction_details` (order_id, gross_amount)
  - `customer_details` (name, email, phone)
  - `item_details` (id, price, quantity, name for each item in the order)

### 3. Webhook Signature Validation (CRITICAL)
- The webhook endpoint must be public to receive Midtrans notifications (`/api/midtrans/callback`), but the handler **MUST** verify the callback source before making database updates.
- Verify signature by hashing `order_id + status_code + gross_amount + server_key` using SHA512:
  ```php
  $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
  ```
- Use `hash_equals()` to compare the calculated signature with the incoming `signature_key` payload to prevent timing attacks.

### 4. Mapping Status Updates
Update payment records and order states dynamically depending on `transaction_status`:
- `settlement` or `capture` (accept) -> `payments.status = 'paid'`, `orders.status = 'order_received'`, record time in `paid_at`.
- `expire` -> `payments.status = 'expired'`, `orders.status = 'cancelled'`.
- `cancel` or `deny` -> `payments.status = 'failed'`.
- Always return HTTP `200 OK` to Midtrans upon successful processing so it knows not to retry the callback.

## Common Mistakes
- **Skipping signature check**: Processing webhooks without comparing signatures leaves the backend vulnerable to spoofing.
- **Putting webhook behind web middleware**: Failing to exclude the webhook route from CSRF protection causes CSRF verification errors (HTTP 419). Exclude it in `bootstrap/app.php` (Laravel 11).
- **Ignoring payment logs**: Failing to save `raw_response` from Midtrans hinders debugging when payment mismatches occur.
