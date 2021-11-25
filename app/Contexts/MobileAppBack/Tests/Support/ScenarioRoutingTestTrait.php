<?php

namespace App\Contexts\MobileAppBack\Tests\Support;

use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\UserLoginInfo;
use Illuminate\Testing\TestResponse;
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

    public function routeGet(string $name, string $token = '', array $routeArgs = []): TestResponse
    {
        return $this->request('get', $name, $token, $routeArgs);
    }

    public function routePost(string $name, string $token = '', array $routeArgs = [], array $params = []): TestResponse
    {
        return $this->request('post', $name, $token, $routeArgs, $params);
    }

    public function routePut(string $name, string $token = '', array $routeArgs = [], array $params = []): TestResponse
    {
        return $this->request('put', $name, $token, $routeArgs, $params);
    }

    public function request(string $method, string $name, string $token = '', array $routeArgs = [], array $params = []): TestResponse
    {
        if ($token) {
            $this->withHeader('Authorization', "Bearer: $token");
        }
        return $this->$method($this->getRoute($name, $routeArgs), $params);
    }

    public function getToken(UserLoginInfo $loginInfo): string
    {
        return $this->post($this->getRoute(RouteName::GET_TOKEN), [
            'identity' => $loginInfo->identity,
            'password' => $loginInfo->password,
            'deviceName' => $loginInfo->deviceName,
        ])->json();
    }
}
