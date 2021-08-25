<?php

namespace App\Contexts\Cards\Infrasctructure\Messaging;

use App\Contexts\Cards\Application\Common\CardsInformable;
use App\Contexts\Cards\Application\Common\CardsReportable;
use App\Contexts\Cards\Infrasctructure\Persistence\CardsReportableRepository;

class ReportingBus
{
    /**
     * @var array<CardsInformable>
     */
    protected array $informables = [];

    public function __construct(private CardsReportableRepository $reportableRepository)
    {
    }

    public function subscribe(CardsInformable $informable): void
    {
        $this->informables[] = $informable;
    }

    public function report(CardsReportable $reportable): void
    {
        $this->reportableRepository->persist($reportable);
        $this->issue($reportable);
    }

    public function acceptReportables(CardsReportable ...$reportables): void
    {
        foreach ($reportables as $reportable) {
            $this->report($reportable);
        }
    }

    protected function issue(CardsReportable $reportable): void
    {
        foreach ($this->informables as $informable) {
            if ($informable->accepts($reportable)) {
                $informable->inform($reportable);
            }
        }
    }
}
