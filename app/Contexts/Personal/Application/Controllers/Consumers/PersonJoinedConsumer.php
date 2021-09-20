<?php

namespace App\Contexts\Personal\Application\Controllers\Consumers;

use App\Contexts\Personal\Application\IntegrationEvents\PersonJoined;
use App\Contexts\Personal\Application\IntegrationEvents\PersonNameFilled;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;

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
