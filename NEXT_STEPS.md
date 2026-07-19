# NEXT_STEPS.md

> Snapshot kondisi terakhir session — dibaca AI berikutnya untuk langsung lanjut kerja.

## Branch Aktif
- **Branch:** `main`
- **Status:** Clean, up-to-date with gitea/main

## File yang Diubah di Session Ini

| File | Perubahan |
|---|---|
| `src/MayarGateway.php` | **Created** — Full Mayar API V2 implementation (266 lines) |
| `src/BillingManager.php` | **Updated** — Added `mayar` driver option |
| `src/RevenueSplit.php` | **Deleted** — Moved to tavp-marketplace |
| `tests/HiveTest.php` | **Updated** — Removed RevenueSplit tests |
| `.gitignore` | **Updated** — Added `.opencode/`, `.phpunit.cache/` |
| `CHANGELOG.md` | **Created** — Documented all changes |
| `README.md` | **Updated** — Added MayarGateway status and roadmap |
| `.opencode/CONTEXT.md` | **Created** — AI session context (Gitea only) |

## Progress Fitur/Task Saat Ini

| Feature | Status | Progress |
|---|---|---|
| MayarGateway | ✅ Complete | 100% |
| Stripe Gateway | ✅ Basic | 50% |
| PayPal Gateway | ✅ Basic | 50% |
| Midtrans Gateway | ✅ Basic | 50% |
| Xendit Gateway | ✅ Basic | 50% |
| Duitku Gateway | ❌ Not started | 0% |
| Flip Business Gateway | ❌ Not started | 0% |
| iPaymu Gateway | ❌ Not started | 0% |
| Invoice PDF Export | ❌ Not started | 0% |
| Webhook Retry | ❌ Not started | 0% |
| Multi-gateway Failover | ❌ Not started | 0% |

## Blocker Terakhir
- **None** — Session completed successfully

## Kerjaan Setengah Jadi/Belum Di-Commit
- **None** — All changes committed and pushed

## TODO Prioritas untuk Sesi Berikutnya

1. **Implement Duitku Gateway** — Indonesia payment gateway
2. **Implement Flip Business Gateway** — Indonesia payment gateway
3. **Implement iPaymu Gateway** — Indonesia payment gateway
4. **Add Invoice PDF Export** — Generate PDF invoices
5. **Add Webhook Retry** — Retry failed webhook calls
6. **Multi-gateway Failover** — Automatic fallback between gateways
7. **Production Testing** — Test with real Mayar API keys
8. **Add More Tests** — Increase test coverage

## Referensi Issue/PR
- **Issue:** feat: Implement MayarGateway for Indonesia payment gateway (created in this session)

## Commit & Push
- `afdecd0` feat: add MayarGateway, remove RevenueSplit (marketplace job)
- `9566c88` chore: add .phpunit.cache to gitignore
- `dceb383` docs: add CHANGELOG.md with session summary
- `02b8a40` docs: update README with MayarGateway status and roadmap

## Wiki Pages Created
- Home
- Architecture
- Payment-Gateways
- Mayar-API
- Development-Log
- Known-Issues
- CHANGELOG

## Config Reference

### Mayar Gateway
```php
'mayar' => [
    'driver' => 'mayar',
    'api_key' => env('MAYAR_API_KEY'),
    'sandbox' => true, // false untuk production
]
```

### API Endpoints
- Production: `https://api.mayar.id/hl/v2`
- Sandbox: `https://api.mayar.club/hl/v2`

### Get API Key
- Production: https://web.mayar.id/api-keys
- Sandbox: https://web.mayar.club/api-keys

## Security Notes
- `.opencode/CONTEXT.md` contains API tokens — NEVER push to GitHub
- API keys should be stored in `.env` files, not in code
- All secrets should be environment variables, not hardcoded

## Remote Repos
- **Gitea (primary):** https://git.glotama.com/tavp-stack/tavphive.git
- **GitHub (mirror):** https://github.com/tavp-stack/tavphive.git

## Gitea API Access
- **Host:** git.glotama.com
- **User:** jtdoank
- **Token:** REDACTED-GITEA-TOKEN (old, works)
- **Token:** _(disimpan lokal di `.opencode/CONTEXT.md`, TIDAK di repo)_
