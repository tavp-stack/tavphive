# Changelog

All notable changes to TAVPhive will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- MayarGateway — full implementation for Mayar API V2 (Indonesia payment gateway)
  - Checkout, Invoice, Membership, Credit, Customer, Transaction, QR Code, Webhook endpoints
  - Sandbox/Production mode support
- `.opencode/CONTEXT.md` — AI session context (Gitea only, not pushed to GitHub)

### Changed
- BillingManager — added `mayar` driver option
- `.gitignore` — added `.opencode/` (AI context, local only), `.phpunit.cache/`

### Removed
- RevenueSplit — moved to `tavp-marketplace` (not TAVPhive scope)

## [0.1.0] - 2026-07-20

### Added
- Initial release — TAVPhive billing module
- Subscription management (plan, trial, cancel, upgrade)
- Payment gateway interface (PaymentGateway)
- Stripe, PayPal, Midtrans, Xendit gateway implementations
- Invoice service
- Billing manager (gateway orchestration)
- Subscription service

[Unreleased]: https://git.glotama.com/tavp-stack/tavphive/compare/v0.1.0...HEAD
[0.1.0]: https://git.glotama.com/tavp-stack/tavphive/releases/tag/v0.1.0
