<?php

namespace App\Contexts\Shared\Infrastructure\Support;

use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ServiceResultCode;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class ServiceResultFactory implements ServiceResultFactoryInterface
{
    public function ok($payload = null, Reportable ...$reportables): ServiceResultInterface
    {
        return ServiceResult::make(ServiceResultCode::OK(), $payload, null, null, ...$reportables);
    }

    public function violation(string $violation, Reportable ...$reportables): ServiceResultInterface
    {
        return ServiceResult::make(ServiceResultCode::POLICY_VIOLATION(), null, $violation, null, ...$reportables);
    }

    public function error(string $error, Reportable ...$reportables): ServiceResultInterface
    {
        return ServiceResult::make(ServiceResultCode::INTERNAL_ERROR(), null, null, $error, ...$reportables);
    }

    public function notFound(string $error, Reportable ...$reportables): ServiceResultInterface
    {
        return ServiceResult::make(ServiceResultCode::SUBJECT_NOT_FOUND(), null, null, $error, ...$reportables);
    }
}
