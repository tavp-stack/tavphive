# tavphive

Module **billing SaaS** untuk TAVP. Buat yang mau bikin produk berlangganan.

## Features

- **Subscriptions** — Plans, trials, cancellation, upgrades
- **Invoicing** — Auto-generated invoices, PDF export
- **Plan management** — Free, pro, enterprise tiers
- **Webhook handling** — Payment event processing
- **Revenue split** — 80% developer, 20% platform

## Payment gateways

| Gateway | Region | Status |
|---|---|---|
| Stripe | International | Supported |
| PayPal | International | Supported |
| Midtrans | Indonesia | Supported |
| Xendit | Indonesia | Supported |
| mayar.id | Indonesia | Supported |
| Duitku | Indonesia | Supported |
| Flip Business | Indonesia | Supported |
| iPaymu | Indonesia | Supported |

## Requirements

- PHP 8.1+
- Phalcon 5.x
- tavp-core

## Install

```bash
# Via tavp CLI
tavp module:install tavp/tavphive

# Via Composer
composer require tavp/tavphive
```

## Quick start

```php
use Tavp\Hive\Subscription;

// Create a subscription
$subscription = Subscription::create([
    'user_id' => $userId,
    'plan' => 'pro',
    'gateway' => 'stripe',
]);

// Check if active
if ($subscription->isActive()) {
    // User has access
}
```

## Database tables

| Table | Description |
|---|---|
| `subscriptions` | Active subscriptions |
| `invoices` | Invoice history |
| `plans` | Available plans |
| `payments` | Payment transactions |

## Testing

```bash
composer test
```

## Status

Part of **0.1.0 Genesis** (ZeroVer `0.MINOR.PATCH`). Basic subscriptions.
Full features (invoicing, webhooks, multi-gateway) in `0.6.0`.

## License

MIT
