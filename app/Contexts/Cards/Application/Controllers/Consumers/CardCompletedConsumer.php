<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\IntegrationEvents\CardArchived;
use App\Contexts\Cards\Application\IntegrationEvents\CardCompleted;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;

final class CardCompletedConsumer implements Informable
{
    public function __construct(private ReportingBusInterface $reportingBus)
    {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof CardCompleted;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var CardCompleted $event */
        $event = $reportable;
        $this->reportingBus->report(new CardArchived($event->id()));
    }

}
