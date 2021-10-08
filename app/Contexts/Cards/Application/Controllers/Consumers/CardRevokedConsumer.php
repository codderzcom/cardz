<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Integration\Events\CardArchived;
use App\Contexts\Cards\Integration\Events\CardRevoked;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;
use App\Shared\Contracts\ReportingBusInterface;

final class CardRevokedConsumer implements Informable
{
    public function __construct(private ReportingBusInterface $reportingBus)
    {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof CardRevoked;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var CardRevoked $event */
        $event = $reportable;
        $this->reportingBus->report(new CardArchived($event->id()));
    }

}
