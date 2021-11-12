<?php

namespace App\Contexts\MobileAppBack\Tests\Customer\Scenario;

use App\Contexts\MobileAppBack\Tests\Shared\BaseScenarioTest;
use App\Contexts\MobileAppBack\Tests\Shared\Customer\CustomerProviderTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerRegistrationTest extends BaseScenarioTest
{
    use RefreshDatabase, CustomerProviderTrait;

    public function test_customer_can_register_and_login()
    {
        $response = $this->post(self::MAB_API . '/customer/register', $this->getCustomer('customer')->toArray());
        $response->assertSuccessful();
        $registrationToken = $response->json();
        $this->assertIsString($registrationToken);

        $response = $this->post(self::MAB_API . '/customer/get-token', [
            'identity' => 'customer',
            'password' => 'customer',
            'deviceName' => 'customer',
        ]);

        $response->assertSuccessful();
        $token = $response->json();
        $this->assertIsString($token);

        $this->assertNotSame($registrationToken, $token);
    }
}
