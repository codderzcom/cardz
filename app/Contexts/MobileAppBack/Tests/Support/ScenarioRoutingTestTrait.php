<?php

namespace App\Contexts\MobileAppBack\Tests\Support;

use Symfony\Component\Routing\Exception\RouteNotFoundException;

trait ScenarioRoutingTestTrait
{
    public function getRoute(string $name, array $arguments = []): string
    {
        try {
            return route($name, $arguments);
        } catch (RouteNotFoundException) {
            $this->fail("Route $name not found");
        }
    }

}
