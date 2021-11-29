<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\Identity\Tests\Support\Builders\UserBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;

class NewCustomerScenarioTest extends BaseScenarioTestCase
{
    public function test_customer_can_register()
    {
        $this->persistEnvironment();
        $userBuilder = UserBuilder::make();

        $token = $this->routePost(RouteName::REGISTER, [], [
            'email' => $userBuilder->email,
            'phone' => $userBuilder->phone,
            'name' => $userBuilder->name,
            'password' => $userBuilder->plainTextPassword,
            'deviceName' => $this->faker->word(),
        ])->json();
        $this->assertMatchesRegularExpression('/\d+\|.{40}/', $token);
    }

    public function test_customer_can_login()
    {
        $this->persistEnvironment();
        $customerInfo = $this->environment->customerInfos[0];

        $token = $this->routePost(RouteName::GET_TOKEN, [], [
            'identity' => $customerInfo->identity,
            'password' => $customerInfo->password,
            'deviceName' => $this->faker->word(),
        ])->json();
        $this->assertMatchesRegularExpression('/\d+\|.{40}/', $token);
    }

}
