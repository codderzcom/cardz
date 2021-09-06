<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\IntegrationEvents\CardIssued;
use App\Contexts\Cards\Application\IntegrationEvents\RequirementsAccepted;
use App\Contexts\Cards\Infrastructure\ACL\Plans\PlansAdapter;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;

final class CardIssuedConsumer implements Informable
{
    public function __construct(
        private ReportingBusInterface $reportingBus,
        private PlansAdapter $plansAdapter,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof CardIssued;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var CardIssued $event */
        $event = $reportable;
        //$this->plansAdapter->getRequirements($event)
        $this->reportingBus->report(new RequirementsAccepted($reportable->getInstanceId()));
    }

}
