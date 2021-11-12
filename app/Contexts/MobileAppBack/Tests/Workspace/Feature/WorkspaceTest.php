<?php

namespace App\Contexts\MobileAppBack\Tests\Workspace\Feature;

use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\CardAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\PlanAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\WorkspaceAppService;
use App\Contexts\MobileAppBack\Tests\Shared\Customer\CustomerProviderTrait;
use App\Contexts\MobileAppBack\Tests\Shared\Customer\CustomerRequestDTO;
use App\Contexts\MobileAppBack\Tests\Shared\LoginTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class WorkspaceTest extends TestCase
{
    use RefreshDatabase, LoginTrait, CustomerProviderTrait;

    protected CustomerAppService $customerAppService;

    protected CardAppService $cardAppService;

    protected PlanAppService $planAppService;

    protected WorkspaceAppService $workspaceAppService;

    public function test_customer_can_keep_workspace()
    {
        $keeperId = $this->setupCustomer($this->getKeeper());
        $workspace = $this->workspaceAppService->addWorkspace($keeperId, 'Workspace', 'Workspace', 'Workspace');

        $this->assertSame($keeperId, $workspace->keeperId);
    }

    public function test_keeper_can_change_workspace_profile()
    {
        $keeperId = $this->setupCustomer($this->getKeeper());
        $workspace = $this->workspaceAppService->addWorkspace($keeperId, 'Workspace', 'Workspace', 'Workspace');
        $workspace = $this->workspaceAppService->changeProfile($workspace->workspaceId, 'Name', 'Description', 'Address');

        $this->assertSame($keeperId, $workspace->keeperId);
        $this->assertSame('Name', $workspace->name);
        $this->assertSame( 'Description', $workspace->description);
        $this->assertSame('Address', $workspace->address);
    }

    public function test_customer_cant_change_random_workspace_profile()
    {
        $keeperId = $this->setupCustomer($this->getKeeper());
        $workspace = $this->workspaceAppService->addWorkspace($keeperId, 'Workspace', 'Workspace', 'Workspace');

        $customerId = $this->setupCustomer($this->getCustomer());
        $this->login($customerId);
        $workspace = $this->workspaceAppService->changeProfile($workspace->workspaceId, 'Name', 'Description', 'Address');

        $this->assertSame($keeperId, $workspace->keeperId);
    }

    protected function setupCustomer(CustomerRequestDTO $client): string
    {
        $this->customerAppService->register($client->email, $client->phone, $client->name, $client->password, $client->deviceName);
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
