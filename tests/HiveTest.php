<?php

declare(strict_types=1);

namespace Tavp\Hive\Tests;

use Tavp\Hive\Subscription;
use PHPUnit\Framework\TestCase;

class HiveTest extends TestCase
{
    public function testSubscriptionFeatures(): void
    {
        $sub = new Subscription('pro', 29.0, ['api', 'teams']);
        $this->assertSame('pro', $sub->plan());
        $this->assertTrue($sub->hasFeature('api'));
        $this->assertFalse($sub->hasFeature('white-label'));
    }
}
