<?php

namespace App\Contexts\MobileAppBack\Application\Contracts;

use App\Contexts\MobileAppBack\Application\Services\Shared\ApplicationServiceResult;

interface ApplicationServiceResultFactoryInterface
{
    public function ok(string $payload): ApplicationServiceResult;

    public function violation(string $violation): ApplicationServiceResult;

    public function error(string $error): ApplicationServiceResult;

    public function notFound(): ApplicationServiceResult;
}
