<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\Identity\Tests\Support\Builders\UserBuilder;

class NewCustomerScenarioTest extends BaseScenarioTestCase
{
    public function test_customer_can_register()
    {
        $this->persistEnvironment();
        $userBuilder = UserBuilder::make();

        $token = $this->post($this->getRoute('MABCustomerRegister'), [
            'email' => $userBuilder->email,
            'phone' => $userBuilder->phone,
            'name' => $userBuilder->name,
            'password' => $userBuilder->plainTextPassword,
            'deviceName' => $this->faker->word(),
        ])->json();
        $this->assertMatchesRegularExpression('/\d+\|.{40}/', $token);
    }

}
