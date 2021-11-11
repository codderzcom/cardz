<?php

namespace App\Contexts\MobileAppBack\Tests\Auth\Feature;

use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerAppService;
use App\Contexts\MobileAppBack\Tests\Shared\CustomerProviderTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, CustomerProviderTrait;

    protected CustomerAppService $customerAppService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customerAppService = $this->app->make(CustomerAppService::class);
    }

    public function test_user_is_authenticated_after_registering()
    {
        $this->customerAppService->register(...$this->getCustomer('user')->toArray());
        $this->assertAuthenticated();
    }

    public function test_user_can_get_token()
    {
        $this->customerAppService->register(...$this->getCustomer('user')->toArray());
        $token = $this->customerAppService->getToken('user', 'user', 'user');
        $this->assertNotEmpty($token);
    }

}
