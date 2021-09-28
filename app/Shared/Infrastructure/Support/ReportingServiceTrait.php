<?php

namespace App\Shared\Infrastructure\Support;

use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultInterface;

trait ReportingServiceTrait
{
    private function reportResult(ServiceResultInterface $result, ReportingBusInterface $reportingBus): ServiceResultInterface
    {
        $reportingBus->reportBatch(...$result->getReportables());
        return $result->ofReported();
    }
}
