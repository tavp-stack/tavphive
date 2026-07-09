<?php

declare(strict_types=1);

namespace Tavp\Hive;

/**
 * Marketplace revenue split calculator.
 *
 * Per TAVP monetisation rule, developers receive 80% of each sale;
 * TAVP retains 20%. This class computes both shares from a gross amount
 * and guards against negative input.
 */
class RevenueSplit
{
    private const DEVELOPER_SHARE = 0.80;
    private const PLATFORM_SHARE = 0.20;

    /**
     * Compute the developer and platform portions of a sale.
     */
    public function split(float $grossAmount): array
    {
        if ($grossAmount < 0) {
            throw new \InvalidArgumentException('Amount cannot be negative.');
        }

        $developer = round($grossAmount * self::DEVELOPER_SHARE, 2);
        $platform = round($grossAmount * self::PLATFORM_SHARE, 2);

        return [
            'gross' => $grossAmount,
            'developer' => $developer,
            'platform' => $platform,
        ];
    }

    public function developerShare(): float
    {
        return self::DEVELOPER_SHARE;
    }

    public function platformShare(): float
    {
        return self::PLATFORM_SHARE;
    }
}
