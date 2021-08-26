<?php

namespace App\Contexts\Shared\Infrasctructure\Messaging;

use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Infrasctructure\Persistence\ReportableRepository;

class ReportingBus implements ReportingBusInterface
{
    /**
     * @var array<Informable>
     */
    protected array $informables = [];

    public function __construct(private ReportableRepository $reportableRepository)
    {
    }

    public function subscribe(Informable $informable): void
    {
        $this->informables[] = $informable;
    }

    public function report(Reportable $reportable): void
    {
        $this->reportableRepository->persist($reportable);
        $this->issue($reportable);
    }

    public function reportBatch(Reportable ...$reportables): void
    {
        foreach ($reportables as $reportable) {
            $this->report($reportable);
        }
    }

    protected function issue(Reportable $reportable): void
    {
        foreach ($this->informables as $informable) {
            if ($informable->accepts($reportable)) {
                $informable->inform($reportable);
            }
        }
    }
}
