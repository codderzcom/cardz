<?php

namespace App\Contexts\Shared\Infrastructure\Persistence;

use App\Contexts\Shared\Contracts\Reportable;
use App\Models\Reportable as EloquentReportable;

class ReportableRepository
{
    public function persist(Reportable $reportable): void
    {
        $eloquentReportable = new EloquentReportable();
        $eloquentReportable->data = (string) $reportable;
        $eloquentReportable->save([

        ]);
    }
}
