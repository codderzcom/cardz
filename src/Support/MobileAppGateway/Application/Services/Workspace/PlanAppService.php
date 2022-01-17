<?php

namespace Cardz\Support\MobileAppGateway\Application\Services\Workspace;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessPlan;
use Cardz\Support\MobileAppGateway\Infrastructure\Exceptions\BusinessPlanNotFoundException;
use Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts\BusinessPlanReadStorageInterface;
use Cardz\Support\MobileAppGateway\Integration\Contracts\PlansContextInterface;

class PlanAppService
{
    public function __construct(
        private PlansContextInterface $plansContext,
        private BusinessPlanReadStorageInterface $businessPlanReadStorage,
    ) {
    }

    /**
     * @throws BusinessPlanNotFoundException
     */
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

    /**
     * @throws BusinessPlanNotFoundException
     */
    public function add(string $workspaceId, string $description): BusinessPlan
    {
        $planId = $this->plansContext->add($workspaceId, $description);
        return $this->businessPlanReadStorage->find($planId);
    }

    /**
     * @throws BusinessPlanNotFoundException
     */
    public function launch(string $planId, string $expirationDate): BusinessPlan
    {
        $this->plansContext->launch($planId, $expirationDate);
        return $this->businessPlanReadStorage->find($planId);
    }

    /**
     * @throws BusinessPlanNotFoundException
     */
    public function stop(string $planId): BusinessPlan
    {
        $this->plansContext->stop($planId);
        return $this->businessPlanReadStorage->find($planId);
    }

    /**
     * @throws BusinessPlanNotFoundException
     */
    public function archive(string $planId): BusinessPlan
    {
        $this->plansContext->archive($planId);
        return $this->businessPlanReadStorage->find($planId);
    }

    /**
     * @throws BusinessPlanNotFoundException
     */
    public function changeDescription(string $planId, string $description): BusinessPlan
    {
        $this->plansContext->changeDescription($planId, $description);
        return $this->businessPlanReadStorage->find($planId);
    }

    /**
     * @throws BusinessPlanNotFoundException
     */
    public function addRequirement(string $planId, string $description): BusinessPlan
    {
        $this->plansContext->addRequirement($planId, $description);
        return $this->businessPlanReadStorage->find($planId);
    }

    /**
     * @throws BusinessPlanNotFoundException
     */
    public function removeRequirement(string $planId, string $requirementId): BusinessPlan
    {
        $this->plansContext->removeRequirement($requirementId);
        return $this->businessPlanReadStorage->find($planId);
    }

    /**
     * @throws BusinessPlanNotFoundException
     */
    public function changeRequirement(string $planId, string $requirementId, string $description): BusinessPlan
    {
        $this->plansContext->changeRequirement($requirementId, $description);
        return $this->businessPlanReadStorage->find($planId);
    }
}
