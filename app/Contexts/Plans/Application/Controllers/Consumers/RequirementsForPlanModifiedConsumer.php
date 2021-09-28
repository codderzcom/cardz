<?php

namespace App\Contexts\Plans\Application\Controllers\Consumers;

use App\Contexts\Plans\Application\IntegrationEvents\PlanRequirementsChanged;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementAdded;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementOfPlan;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementRemoved;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;
use App\Shared\Contracts\ReportingBusInterface;

final class RequirementsForPlanModifiedConsumer implements Informable
{
    public function __construct(
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
        /** @var RequirementOfPlan $event */
        $event = $reportable;
        $this->reportingBus->report(new PlanRequirementsChanged($event->getPlanId()));
    }

}
