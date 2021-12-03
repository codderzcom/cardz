<?php

namespace Cardz\Support\MobileAppGateway\Tests\Feature\Authorization;

use Cardz\Support\MobileAppGateway\Config\Routes\RouteName;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;
use Illuminate\Routing\Router;

class AuthorizationTest extends BaseTestCase
{
    use ApplicationTestTrait;

    public function test_authorization_middleware_enabled()
    {
        /** @var Router $router */
        $router = $this->app->make(Router::class);
        $middleware = $router->getRoutes()->getByName(RouteName::GET_WORKSPACE)->middleware();
        $this->assertContains('authorization.mag', $middleware);
        $middleware = $router->getRoutes()->getByName(RouteName::GET_PLANS)->middleware();
        $this->assertContains('authorization.mag', $middleware);
    }
}
