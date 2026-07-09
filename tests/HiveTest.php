<?php

declare(strict_types=1);

namespace Tavp\Hive\Tests;

use Tavp\Hive\RevenueSplit;
use Tavp\Hive\Subscription;
use PHPUnit\Framework\TestCase;

class HiveTest extends TestCase
{
    public function testRevenueSplitIsEightyTwenty(): void
    {
        $split = new RevenueSplit();
        $result = $split->split(100.00);

        $this->assertSame(80.0, $result['developer']);
        $this->assertSame(20.0, $result['platform']);
        $this->assertSame(0.80, $split->developerShare());
        $this->assertSame(0.20, $split->platformShare());
    }

    public function testNegativeAmountThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new RevenueSplit())->split(-5);
    }

    public function testSubscriptionFeatures(): void
    {
        $sub = new Subscription('pro', 29.0, ['api', 'teams']);
        $this->assertSame('pro', $sub->plan());
        $this->assertTrue($sub->hasFeature('api'));
        $this->assertFalse($sub->hasFeature('white-label'));
    }
}
