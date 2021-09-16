<?php

namespace App\Contexts\Plans\Application\Controllers\Consumers;

use App\Contexts\Plans\Application\IntegrationEvents\PlanAdded;
use App\Contexts\Plans\Application\IntegrationEvents\PlanDescriptionFilled;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;

final class PlanAddedConsumer implements Informable
{
    public function __construct(private ReportingBusInterface $reportingBus)
    {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof PlanAdded;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var PlanAdded $event */
        $event = $reportable;
        $this->reportingBus->report(new PlanDescriptionFilled($event->getInstanceId()));
    }

}
