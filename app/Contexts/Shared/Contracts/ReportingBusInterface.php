<?php

namespace App\Contexts\Shared\Contracts;

interface ReportingBusInterface
{
    public function subscribe(Informable $informable): void;

    public function report(Reportable $reportable): void;

    public function reportBatch(Reportable ...$reportables): void;
}
