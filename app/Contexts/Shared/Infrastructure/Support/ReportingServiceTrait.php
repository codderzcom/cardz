<?php

namespace App\Contexts\Shared\Infrastructure\Support;

use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

trait ReportingServiceTrait
{
    private function reportResult(ServiceResultInterface $result, ReportingBusInterface $reportingBus): ServiceResultInterface
    {
        $reportingBus->reportBatch(...$result->getReportables());
        return $result->ofReported();
    }
}
