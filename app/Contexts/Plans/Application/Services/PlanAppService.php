<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Application\IntegrationEvents\PlanAdded;
use App\Contexts\Plans\Application\IntegrationEvents\PlanArchived;
use App\Contexts\Plans\Application\IntegrationEvents\PlanDescriptionChanged;
use App\Contexts\Plans\Application\IntegrationEvents\PlanLaunched;
use App\Contexts\Plans\Application\IntegrationEvents\PlanRequirementsChanged;
use App\Contexts\Plans\Application\IntegrationEvents\PlanStopped;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Plan\Requirement;
use App\Contexts\Plans\Domain\Model\Plan\Requirements;
use App\Contexts\Plans\Domain\Model\Shared\Description;
use App\Contexts\Plans\Domain\Model\Shared\WorkspaceId;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;

class PlanAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $resultFactory,
    ) {
    }

    public function add(string $workspaceId, string $description): ServiceResultInterface
    {
        $plan = Plan::make(
            PlanId::make(),
            WorkspaceId::of($workspaceId),
            Description::of($description)
        );

        $plan->add();
        $this->planRepository->persist($plan);

        $result = $this->resultFactory->ok($plan, new PlanAdded($plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function launch(string $planId): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $plan->launch();
        $this->planRepository->persist($plan);

        $result = $this->resultFactory->ok($plan, new PlanLaunched($plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function stop(string $planId): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $plan->stop();
        $this->planRepository->persist($plan);

        $result = $this->resultFactory->ok($plan, new PlanStopped($plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function archive(string $planId): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $plan->archive();
        $this->planRepository->persist($plan);

        $result = $this->resultFactory->ok($plan, new PlanArchived($plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function changeDescription(string $planId, string $description): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $plan->changeDescription(Description::of($description));
        $this->planRepository->persist($plan);

        $result = $this->resultFactory->ok($plan, new PlanDescriptionChanged($plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function addRequirement(string $planId, string $description): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $requirements = $plan->getRequirements()->add(Requirement::of($description));
        $plan->changeRequirements($requirements);
        $this->planRepository->persist($plan);

        $result = $this->resultFactory->ok($plan, new PlanRequirementsChanged($plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function removeRequirement(string $planId, string $description): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $requirements = $plan->getRequirements()->remove(Requirement::of($description));
        $plan->changeRequirements($requirements);
        $this->planRepository->persist($plan);

        $result = $this->resultFactory->ok($plan, new PlanRequirementsChanged($plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function changeRequirements(string $planId, string ...$descriptions): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $requirements = Requirements::of(...$descriptions);
        $plan->changeRequirements($requirements);
        $this->planRepository->persist($plan);

        $result = $this->resultFactory->ok($plan, new PlanRequirementsChanged($plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

}
