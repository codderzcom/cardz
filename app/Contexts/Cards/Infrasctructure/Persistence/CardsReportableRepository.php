<?php

namespace App\Contexts\Cards\Infrasctructure\Persistence;

use App\Contexts\Cards\Application\Common\CardsReportable;
use App\Models\Reportable as EloquentReportable;

class CardsReportableRepository
{
    public function persist(CardsReportable $reportable): void
    {
        $eloquentReportable = new EloquentReportable();
        $eloquentReportable->data = (string) $reportable;
        $eloquentReportable->save([

        ]);
    }
}
