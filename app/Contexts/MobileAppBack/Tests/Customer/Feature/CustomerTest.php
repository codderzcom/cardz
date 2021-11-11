<?php

namespace App\Contexts\MobileAppBack\Tests\Customer\Feature;

use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\CardAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\PlanAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\WorkspaceAppService;
use App\Contexts\MobileAppBack\Infrastructure\Exceptions\IssuedCardNotFoundException;
use App\Contexts\MobileAppBack\Tests\Shared\CustomerDTO;
use App\Contexts\MobileAppBack\Tests\Shared\CustomerProviderTrait;
use App\Contexts\MobileAppBack\Tests\Shared\LoginTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase, LoginTrait, CustomerProviderTrait;

    protected CustomerAppService $customerAppService;

    protected CardAppService $cardAppService;

    protected PlanAppService $planAppService;

    protected WorkspaceAppService $workspaceAppService;

    public function test_customer_can_get_his_issued_card()
    {
        $customerId = $this->setupCustomer($this->getCustomer());
        $keeperId = $this->setupCustomer($this->getKeeper());

        $cardId = $this->setupCards($customerId, $keeperId);

        $card = $this->customerAppService->getIssuedCard($customerId, $cardId);

        $this->assertSame($customerId, $card->customerId);
    }

    public function test_customer_can_get_his_issued_cards()
    {
        $customerId = $this->setupCustomer($this->getCustomer());
        $keeperId = $this->setupCustomer($this->getKeeper());

        $this->setupCards($customerId, $keeperId, 2);

        $cards = $this->customerAppService->getIssuedCards($customerId);

        $this->assertIsArray($cards);
        $this->assertCount(2, $cards);
    }

    public function test_customer_cant_get_anothers_issued_card()
    {
        $customerId = $this->setupCustomer($this->getCustomer());
        $keeperId = $this->setupCustomer($this->getKeeper());
        $anotherCustomerId = $this->setupCustomer($this->getAnotherCustomer());

        $cardId = $this->setupCards($customerId, $keeperId);

        $this->expectException(IssuedCardNotFoundException::class);
        $this->customerAppService->getIssuedCard($anotherCustomerId, $cardId);
    }

    protected function setupCards($customerId, $keeperId, $count = 1): array|string
    {
        $this->login($keeperId);
        $workspace = $this->workspaceAppService->addWorkspace($keeperId, 'uno', 'uno', 'uno');
        $plan = $this->planAppService->add($workspace->workspaceId, 'uno');

        $cards = [];
        for ($i = 0; $i < $count; $i++) {
            $cards[] = $this->cardAppService->issue($plan->planId, $customerId)->cardId;
        }
        return count($cards) > 1 ? $cards : $cards[0];
    }

    protected function setupCustomer(CustomerDTO $client): string
    {
        $this->customerAppService->register(...$client->toArray());
        return Auth::id();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->customerAppService = $this->app->make(CustomerAppService::class);
        $this->cardAppService = $this->app->make(CardAppService::class);
        $this->planAppService = $this->app->make(PlanAppService::class);
        $this->workspaceAppService = $this->app->make(WorkspaceAppService::class);
    }

}
