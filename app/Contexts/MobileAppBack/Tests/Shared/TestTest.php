<?php

namespace App\Contexts\MobileAppBack\Tests\Shared;

class TestTest extends BaseScenarioTest
{

    public function test_stuff()
    {
        $route = RouteHelper::getUrl( RouteHelper::MABCardBlock, ['workspaceId' => '1', 'cardId' => '1']);
        $this->assertNotEmpty($route);
    }

}
