<?php

namespace App\Contexts\MobileAppBack\Tests\Support;

trait ScenarioRoutingTestTrait
{
    protected string $basePrefix = '/api/mab/v1';
    protected array $routes = [

    ];

    public function getRoute(string $name, ...$arguments)
    {
        $route = $this->routes[$name] ?? null;
        if ($route === null) {
            $this->fail("Route not found");
        }
    }

}
