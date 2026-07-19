# tavphive

Module **billing SaaS** untuk TAVP. Buat yang mau bikin produk berlangganan.

## Features

- **Subscriptions** — Plans, trials, cancellation, upgrades
- **Invoicing** — Auto-generated invoices, PDF export
- **Plan management** — Free, pro, enterprise tiers
- **Webhook handling** — Payment event processing
- **Multi-gateway** — Connect multiple payment gateways simultaneously

## Payment gateways

| Gateway | Region | Status |
|---|---|---|
| **mayar.id** | Indonesia | ✅ Full Implementation |
| Stripe | International | Supported |
| PayPal | International | Supported |
| Midtrans | Indonesia | Supported |
| Xendit | Indonesia | Supported |
| Duitku | Indonesia | Planned |
| Flip Business | Indonesia | Planned |
| iPaymu | Indonesia | Planned |

## Requirements

- PHP 8.3+
- Phalcon 5.16+
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
use Tavp\Hive\BillingManager;

// Initialize billing with Mayar gateway
$billing = new BillingManager([
    'gateways' => [
        'mayar' => [
            'driver' => 'mayar',
            'api_key' => env('MAYAR_API_KEY'),
            'sandbox' => true, // false untuk production
        ],
    ],
]);

// Create checkout
$result = $billing->createCheckout('mayar', [
    'product_name' => 'Pro Plan',
    'amount' => 290000,
    'currency' => 'IDR',
]);

// Redirect user to checkout URL
header('Location: ' . $result['checkout_url']);
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

Part of **0.1.0 Genesis** (ZeroVer `0.MINOR.PATCH`).

### Current Progress
- ✅ MayarGateway — full implementation (checkout, invoice, membership, credit, customer, transaction, QR, webhook)
- ✅ Stripe, PayPal, Midtrans, Xendit — basic implementations
- 🔄 Duitku, Flip Business, iPaymu — planned

### Roadmap
- `0.2.0` — Additional Indonesia gateways (Duitku, Flip, iPaymu)
- `0.3.0` — Invoice PDF export
- `0.4.0` — Webhook retry & logging
- `0.5.0` — Multi-gateway failover
- `0.6.0` — Full production ready

## License

MIT
