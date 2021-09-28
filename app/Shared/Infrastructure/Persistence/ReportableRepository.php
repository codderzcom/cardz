<?php

namespace App\Shared\Infrastructure\Persistence;

use App\Models\Reportable as EloquentReportable;
use App\Shared\Contracts\Reportable;

class ReportableRepository
{
    public function persist(Reportable $reportable): void
    {
        $eloquentReportable = new EloquentReportable();
        $eloquentReportable->name = (string) $reportable;
        $eloquentReportable->data = $reportable->payload();
        $eloquentReportable->save([

        ]);
    }
}
