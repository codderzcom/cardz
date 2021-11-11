<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessPlan;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessPlanReadStorageInterface;
use App\Contexts\MobileAppBack\Integration\Contracts\PlansContextInterface;

class PlanAppService
{
    public function __construct(
        private PlansContextInterface $plansContext,
        private BusinessPlanReadStorageInterface $businessPlanReadStorage,
    ) {
    }

    public function getBusinessPlan(string $planId): BusinessPlan
    {
        return $this->businessPlanReadStorage->find($planId);
    }

    /**
     * @return BusinessPlan[]
     */
    public function getWorkspaceBusinessPlans(string $workspaceId): array
    {
        return $this->businessPlanReadStorage->allForWorkspace($workspaceId);
    }

    public function add(string $workspaceId, string $description): BusinessPlan
    {
        $planId = $this->plansContext->add($workspaceId, $description);
        return $this->businessPlanReadStorage->find($planId);
    }

    public function launch(string $planId): BusinessPlan
    {
        $this->plansContext->launch($planId);
        return $this->businessPlanReadStorage->find($planId);
    }

    public function stop(string $planId): BusinessPlan
    {
        $this->plansContext->stop($planId);
        return $this->businessPlanReadStorage->find($planId);
    }

    public function archive(string $planId): BusinessPlan
    {
        $this->plansContext->archive($planId);
        return $this->businessPlanReadStorage->find($planId);
    }

    public function changeDescription(string $planId, string $description): BusinessPlan
    {
        $this->plansContext->changeDescription($planId, $description);
        return $this->businessPlanReadStorage->find($planId);
    }

    public function addRequirement(string $planId, string $description): BusinessPlan
    {
        $this->plansContext->addRequirement($planId, $description);
        return $this->businessPlanReadStorage->find($planId);
    }

    public function removeRequirement(string $planId, string $requirementId): BusinessPlan
    {
        $this->plansContext->removeRequirement($requirementId);
        return $this->businessPlanReadStorage->find($planId);
    }

    public function changeRequirement(string $planId, string $requirementId, string $description): BusinessPlan
    {
        $this->plansContext->changeRequirement($requirementId, $description);
        return $this->businessPlanReadStorage->find($planId);
    }
}
