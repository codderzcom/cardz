<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\Cards\Tests\Support\Builders\PlanBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;

class RequirementTest extends BaseScenarioTestCase
{
    public function test_requirement_can_be_worked_on_by_collaborator()
    {
        $this->persistEnvironment();
    }

}
