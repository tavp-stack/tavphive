<?php

declare(strict_types=1);

namespace Tavp\Hive;

/**
 * A simple subscription plan definition for TAVPhive billing.
 */
class Subscription
{
    public function __construct(
        private string $plan,
        private float $priceMonthly,
        private array $features = [],
    ) {
    }

    public function plan(): string
    {
        return $this->plan;
    }

    public function priceMonthly(): float
    {
        return $this->priceMonthly;
    }

    public function features(): array
    {
        return $this->features;
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features, true);
    }
}
