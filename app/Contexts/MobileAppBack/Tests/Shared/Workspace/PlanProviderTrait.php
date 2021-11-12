<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Workspace;

trait PlanProviderTrait
{
    public function getPlan(string $populateWith = 'plan'): PlanRequestDTO
    {
        return new PlanRequestDTO($populateWith);
    }

    public function getAnotherPlan(): PlanRequestDTO
    {
        return $this->getPlan( 'another');
    }
}
