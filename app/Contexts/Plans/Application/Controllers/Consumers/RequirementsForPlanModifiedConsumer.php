<?php

namespace App\Contexts\Plans\Application\Controllers\Consumers;

use App\Contexts\Plans\Application\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Application\IntegrationEvents\PlanRequirementsChanged;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementAdded;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementRemoved;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;

final class RequirementsForPlanModifiedConsumer implements Informable
{
    public function __construct(
        private RequirementRepositoryInterface $requirementRepository,
        private ReportingBusInterface $reportingBus,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof RequirementAdded
            || $reportable instanceof RequirementRemoved;
    }

    public function inform(Reportable $reportable): void
    {
        $requirement = $this->requirementRepository->take(RequirementId::of($reportable->getInstanceId()));
        if ($requirement === null) {
            return;
        }
        $this->reportingBus->report(new PlanRequirementsChanged($requirement->planId));
    }

}
