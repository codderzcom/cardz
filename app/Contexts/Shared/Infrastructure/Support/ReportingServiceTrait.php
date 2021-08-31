<?php

namespace App\Contexts\Shared\Infrastructure\Support;

use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use ReflectionClass;
use Throwable;

trait ReportingServiceTrait
{
    abstract private function getReportingBus(): ReportingBusInterface;

    abstract private function getServiceResultFactory(): ServiceResultFactoryInterface;

    protected function report(Reportable ...$reportables): void
    {
        $this->getReportingBus()->reportBatch(...$reportables);
    }

    public function __call(string $name, array $arguments): ServiceResultInterface
    {
        $reflection = new ReflectionClass($this);
        if (!$reflection->hasMethod($name)) {
            return $this->getServiceResultFactory()->error("Callable not found for $name");
        }
        $reflectionMethod = $reflection->getMethod($name);
        try {
            $result = $reflectionMethod->invoke($this, $arguments);
            if ($result instanceof ServiceResultInterface) {
                return $result;
            }
            if ($result instanceof Reportable) {
                $this->getReportingBus()->report($result);
                return $this->getServiceResultFactory();
            }
            if (is_array($result)) {
            }
        } catch (Throwable $exception) {
            return $this->getServiceResultFactory()->error($exception->getMessage());
        }
        return $this->getServiceResultFactory()->error("Cannot handle $name call");
    }

    /**
     * @return array<Reportable>
     */
    private function extractReportablesFromResult($result): array
    {
        $reportables = [];

        if ($result instanceof Reportable) {
            return [$result];
        }

        if (!is_array($result)) {
            return $reportables;
        }

        foreach ($result as $resultItem) {
            if ($resultItem instanceof Reportable) {
                $reportables[] = $resultItem;
            }
        }
        return $reportables;
    }
}
