<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\IntegrationEvents\CardArchived;
use App\Contexts\Plans\Application\IntegrationEvents\PlanRequirementsChanged as PlansPlanRequirementsChanged;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;

final class PlansRequirementsChangedConsumer implements Informable
{
    public function __construct(
        private ReportingBusInterface $reportingBus
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        //ToDo: InterContext dependency.
        return $reportable instanceof PlansPlanRequirementsChanged;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var PlansPlanRequirementsChanged $event */
        $event = $reportable;
        $this->reportingBus->report(new CardArchived($reportable->getInstanceId()));
    }

}
