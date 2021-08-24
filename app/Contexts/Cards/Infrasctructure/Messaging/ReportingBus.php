<?php

namespace App\Contexts\Cards\Infrasctructure\Messaging;

use App\Contexts\Cards\Application\IntegrationEvents\CardsReportable;

class ReportingBus
{
    /**
     * @var array<CardsReportable>
     */
    protected array $reportables = [];

    public function acceptReportable(CardsReportable $reportable): void
    {
        $this->persist($reportable);
    }

    protected function persist(CardsReportable $reportable): void
    {
        $this->reportables[] = $reportable;
    }
}
