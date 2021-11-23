<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\MobileAppBack\Tests\Shared\Builders\EnvironmentBuilder;

class NewCustomerScenarioTest extends BaseScenarioTestCase
{
    public function test_customer_can_appear()
    {
        $environmentBuilder = EnvironmentBuilder::make();

        dd($environmentBuilder->cards[1]);

        $this->assertTrue(true);
    }

}
