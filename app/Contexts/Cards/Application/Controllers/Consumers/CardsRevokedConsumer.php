<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\Common\CardsInformable;
use App\Contexts\Cards\Application\Common\CardsReportable;
use App\Contexts\Cards\Application\IntegrationEvents\CardArchived;
use App\Contexts\Cards\Application\IntegrationEvents\CardCompleted;
use App\Contexts\Cards\Application\IntegrationEvents\CardRevoked;
use App\Contexts\Cards\Infrasctructure\Messaging\ReportingBus;

class CardsRevokedConsumer implements CardsInformable
{
    public function __construct(public ReportingBus $reportingBus)
    {
    }

    public function accepts(CardsReportable $reportable): bool
    {
        return $reportable instanceof CardRevoked;
    }

    public function inform(CardsReportable $reportable): void
    {
        /** @var CardRevoked $event */
        $event = $reportable;
        $this->reportingBus->report(new CardArchived($reportable->getInstanceId(), $reportable->getInstanceOf()));
    }

}
