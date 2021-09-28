<?php

namespace App\Contexts\Personal\Application\Controllers\Consumers;

use App\Contexts\Personal\Application\IntegrationEvents\PersonJoined;
use App\Contexts\Personal\Application\IntegrationEvents\PersonNameFilled;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;
use App\Shared\Contracts\ReportingBusInterface;

final class PersonJoinedConsumer implements Informable
{
    public function __construct(private ReportingBusInterface $reportingBus)
    {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof PersonJoined;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var PersonJoined $event */
        $event = $reportable;
        $this->reportingBus->report(new PersonNameFilled($event->id()));
    }
}
