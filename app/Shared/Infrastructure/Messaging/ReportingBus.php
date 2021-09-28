<?php

namespace App\Shared\Infrastructure\Messaging;

use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Infrastructure\Persistence\ReportableRepository;

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

    public function reportBatch(Reportable ...$reportables): void
    {
        foreach ($reportables as $reportable) {
            $this->report($reportable);
        }
    }

    public function report(Reportable $reportable): void
    {
        $this->reportableRepository->persist($reportable);
        $this->issue($reportable);
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
