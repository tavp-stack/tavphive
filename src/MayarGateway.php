<?php

declare(strict_types=1);

namespace Tavp\Hive;

/**
 * Mayar payment gateway (Indonesia).
 *
 * @see https://docs.mayar.id/api-reference-v2/introduction
 */
class MayarGateway implements PaymentGateway
{
    private string $apiKey;
    private string $baseUrl;
    private bool $sandbox;

    public function __construct(array $config)
    {
        $this->apiKey = $config['api_key'] ?? '';
        $this->sandbox = $config['sandbox'] ?? false;
        $this->baseUrl = $this->sandbox
            ? 'https://api.mayar.club/hl/v2'
            : 'https://api.mayar.id/hl/v2';
    }

    /**
     * Create a checkout session (invoice).
     */
    public function createCheckout(array $data): array
    {
        $payload = [
            'name' => $data['product_name'] ?? 'Subscription',
            'amount' => $data['amount'] ?? 0,
            'type' => 'DIGITAL',
            'currency' => $data['currency'] ?? 'IDR',
        ];

        $response = $this->request('POST', '/product/createpaymentlink', $payload);

        return [
            'checkout_url' => $response['data']['url'] ?? '',
            'invoice_id' => $response['data']['id'] ?? '',
        ];
    }

    /**
     * Verify a payment by invoice ID.
     */
    public function verifyPayment(string $id): array
    {
        $response = $this->request('GET', "/invoice/{$id}");

        return [
            'status' => $response['data']['status'] ?? 'unknown',
            'paid_at' => $response['data']['paid_at'] ?? null,
            'amount' => $response['data']['amount'] ?? 0,
        ];
    }

    /**
     * Handle incoming webhook payload.
     */
    public function handleWebhook(array $payload, string $signature): array
    {
        // Mayar sends event type in payload
        $eventType = $payload['event'] ?? 'unknown';

        return [
            'type' => $eventType,
            'invoice_id' => $payload['data']['id'] ?? null,
            'status' => $payload['data']['status'] ?? null,
        ];
    }

    // ─── Membership Endpoints ────────────────────────────────────────

    /**
     * Register a new membership member.
     */
    public function registerMember(array $data): array
    {
        $response = $this->request('POST', '/membership/register', [
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'product_id' => $data['product_id'] ?? '',
            'tier_id' => $data['tier_id'] ?? '',
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Get membership member detail.
     */
    public function getMember(string $memberId): array
    {
        $response = $this->request('GET', "/membership/member/{$memberId}");

        return $response['data'] ?? [];
    }

    /**
     * List all members of a membership product.
     */
    public function listMembers(string $productId): array
    {
        $response = $this->request('GET', "/membership/members/{$productId}");

        return $response['data'] ?? [];
    }

    /**
     * Update membership member.
     */
    public function updateMember(string $memberId, array $data): array
    {
        $response = $this->request('PATCH', "/membership/member/{$memberId}", $data);

        return $response['data'] ?? [];
    }

    /**
     * Cancel membership member (set status to stopped).
     */
    public function cancelMember(string $memberId): array
    {
        $response = $this->request('POST', "/membership/cancel/{$memberId}");

        return $response['data'] ?? [];
    }

    /**
     * Create invoice for membership billing term.
     */
    public function createMembershipInvoice(array $data): array
    {
        $response = $this->request('POST', '/membership/createinvoice', [
            'member_id' => $data['member_id'] ?? '',
            'amount' => $data['amount'] ?? 0,
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Get membership tiers.
     */
    public function getMembershipTiers(string $productId): array
    {
        $response = $this->request('GET', "/membership/tiers/{$productId}");

        return $response['data'] ?? [];
    }

    // ─── Invoice Endpoints ───────────────────────────────────────────

    /**
     * Create an invoice.
     */
    public function createInvoice(array $data): array
    {
        $response = $this->request('POST', '/invoice/create', [
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'amount' => $data['amount'] ?? 0,
            'expired' => $data['expired'] ?? date('Y-m-d', strtotime('+7 days')),
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Get invoice detail.
     */
    public function getInvoice(string $invoiceId): array
    {
        $response = $this->request('GET', "/invoice/{$invoiceId}");

        return $response['data'] ?? [];
    }

    /**
     * List invoices with optional filter.
     */
    public function listInvoices(array $filters = []): array
    {
        $query = http_build_query($filters);
        $response = $this->request('GET', "/invoice?{$query}");

        return $response['data'] ?? [];
    }

    // ─── Customer Endpoints ──────────────────────────────────────────

    /**
     * Create a customer.
     */
    public function createCustomer(array $data): array
    {
        $response = $this->request('POST', '/customer/create', [
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Get customer detail.
     */
    public function getCustomer(string $email): array
    {
        $response = $this->request('GET', "/customer/{$email}");

        return $response['data'] ?? [];
    }

    /**
     * Search customer by email.
     */
    public function searchCustomer(string $email): array
    {
        $response = $this->request('GET', "/customer/search/{$email}");

        return $response['data'] ?? [];
    }

    // ─── Credit Endpoints ────────────────────────────────────────────

    /**
     * Add credit to customer.
     */
    public function addCredit(string $memberId, int $amount): array
    {
        $response = $this->request('POST', '/credit/add', [
            'member_id' => $memberId,
            'amount' => $amount,
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Spend customer credit.
     */
    public function spendCredit(string $memberId, int $amount): array
    {
        $response = $this->request('POST', '/credit/spend', [
            'member_id' => $memberId,
            'amount' => $amount,
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Get customer credit balance.
     */
    public function getCreditBalance(string $memberId): array
    {
        $response = $this->request('GET', "/credit/balance/{$memberId}");

        return $response['data'] ?? [];
    }

    // ─── Transaction Endpoints ───────────────────────────────────────

    /**
     * Get paid transactions.
     */
    public function getPaidTransactions(array $filters = []): array
    {
        $query = http_build_query($filters);
        $response = $this->request('GET', "/transaction/paid?{$query}");

        return $response['data'] ?? [];
    }

    /**
     * Get unpaid transactions.
     */
    public function getUnpaidTransactions(array $filters = []): array
    {
        $query = http_build_query($filters);
        $response = $this->request('GET', "/transaction/unpaid?{$query}");

        return $response['data'] ?? [];
    }

    // ─── QR Code Endpoints ───────────────────────────────────────────

    /**
     * Create dynamic QR code for specific amount.
     */
    public function createDynamicQR(int $amount): array
    {
        $response = $this->request('POST', '/qrcode/dynamic', [
            'amount' => $amount,
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Get static QR code.
     */
    public function getStaticQR(): array
    {
        $response = $this->request('GET', '/qrcode/static');

        return $response['data'] ?? [];
    }

    // ─── Webhook Endpoints ───────────────────────────────────────────

    /**
     * Register webhook URL.
     */
    public function registerWebhook(string $url): array
    {
        $response = $this->request('POST', '/webhook/register', [
            'url' => $url,
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Test webhook URL.
     */
    public function testWebhook(string $url): array
    {
        $response = $this->request('POST', '/webhook/test', [
            'url' => $url,
        ]);

        return $response['data'] ?? [];
    }

    /**
     * Get webhook history.
     */
    public function getWebhookHistory(): array
    {
        $response = $this->request('GET', '/webhook/history');

        return $response['data'] ?? [];
    }

    // ─── Account Endpoints ───────────────────────────────────────────

    /**
     * Get account balance.
     */
    public function getBalance(): array
    {
        $response = $this->request('GET', '/balance');

        return $response['data'] ?? [];
    }

    // ─── Internal HTTP Client ────────────────────────────────────────

    /**
     * Make HTTP request to Mayar API.
     */
    private function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => $method,
        ]);

        if ($method !== 'GET' && !empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true) ?? [];

        if ($httpCode >= 400) {
            throw new \RuntimeException(
                "Mayar API error {$httpCode}: " . ($decoded['messages'] ?? 'Unknown error')
            );
        }

        return $decoded;
    }
}
