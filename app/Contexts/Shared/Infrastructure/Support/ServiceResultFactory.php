<?php

namespace App\Contexts\Shared\Infrastructure\Support;

use App\Contexts\Shared\Contracts\ServiceResultCode;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;

class ServiceResultFactory extends ServiceResult implements ServiceResultFactoryInterface
{
    public function ok(string $payload): ServiceResult
    {
        return new ServiceResult(ServiceResultCode::OK(), $payload);
    }

    public function violation(string $violation): ServiceResult
    {
        return new ServiceResult(ServiceResultCode::POLICY_VIOLATION(), null, $violation);
    }

    public function error(string $error): ServiceResult
    {
        return new ServiceResult(ServiceResultCode::INTERNAL_ERROR(), null, null, $error);
    }

    public function notFound(): ServiceResult
    {
        return new ServiceResult(ServiceResultCode::SUBJECT_NOT_FOUND(), null, null, null);
    }
}
