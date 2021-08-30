<?php

namespace App\Contexts\MobileAppBack\Application\Services\Shared;

use App\Contexts\MobileAppBack\Application\Contracts\ApplicationServiceResultFactoryInterface;
use App\Contexts\MobileAppBack\Application\Contracts\ApplicationServiceResultCode;

class ApplicationServiceResultFactory extends ApplicationServiceResult implements ApplicationServiceResultFactoryInterface
{
    public function ok(string $payload): ApplicationServiceResult
    {
        return new ApplicationServiceResult(ApplicationServiceResultCode::OK(), $payload);
    }

    public function violation(string $violation): ApplicationServiceResult
    {
        return new ApplicationServiceResult(ApplicationServiceResultCode::POLICY_VIOLATION(), null, $violation);
    }

    public function error(string $error): ApplicationServiceResult
    {
        return new ApplicationServiceResult(ApplicationServiceResultCode::INTERNAL_ERROR(), null, null, $error);
    }

    public function notFound(): ApplicationServiceResult
    {
        return new ApplicationServiceResult(ApplicationServiceResultCode::SUBJECT_NOT_FOUND(), null, null, null);
    }
}
