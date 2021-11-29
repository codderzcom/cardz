<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Workspace;

use App\Contexts\MobileAppBack\Tests\Shared\Customer\CustomerProviderTrait;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

trait SetupScenarioEnvironmentTrait
{
    use CustomerProviderTrait, PlanProviderTrait, WorkspaceProviderTrait, MakesHttpRequests;

    protected string $mabApi = '/api/mab/v1';

    protected string $firstKeeperToken;

    protected string $secondKeeperToken;

    protected string $firstCustomerToken;

    protected string $secondCustomerToken;

    protected string $firstWorkspaceId;

    protected string $secondWorkspaceId;

    protected string $firstPlanId;

    protected string $secondPlanId;

    protected array $cardIds = [];

    protected function setupEnvironment(): void
    {
        $this->firstKeeperToken = $this
            ->post("$this->mabApi/customer/register", $this->getCustomer('firstKeeper')->toArray())
            ->json();

        $this->secondKeeperToken = $this
            ->post("$this->mabApi/customer/register", $this->getCustomer('secondKeeper')->toArray())
            ->json();

        $this->firstCustomerToken = $this
            ->post("$this->mabApi/customer/register", $this->getCustomer('firstCustomer')->toArray())
            ->json();

        $this->secondCustomerToken = $this
            ->post("$this->mabApi/customer/register", $this->getCustomer('secondCustomer')->toArray())
            ->json();

        $this->firstWorkspaceId = $this->withHeader('Authorization', 'Bearer: ' . $this->firstKeeperToken)
            ->post("$this->mabApi/workspace", $this->getWorkspace()->toArray())
            ->json('workspaceId');

        $this->secondWorkspaceId = $this->withHeader('Authorization', 'Bearer: ' . $this->secondKeeperToken)
            ->post("$this->mabApi/workspace", $this->getWorkspace()->toArray())
            ->json('workspaceId');

        $this->firstPlanId = $this->withHeader('Authorization', 'Bearer: ' . $this->firstKeeperToken)
            ->post("$this->mabApi/workspace/$this->firstWorkspaceId/plan", $this->getPlan()->toArray())
            ->json('planId');


        $this->secondWorkspaceId = '';
        $this->secondPlanId = '';
    }

}
