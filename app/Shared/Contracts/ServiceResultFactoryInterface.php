<?php

namespace App\Shared\Contracts;

interface ServiceResultFactoryInterface
{
    public function ok($payload = null, Reportable ...$reportables): ServiceResultInterface;

    public function violation(string $violation, Reportable ...$reportables): ServiceResultInterface;

    public function error(string $error, Reportable ...$reportables): ServiceResultInterface;

    public function notFound(string $error, Reportable ...$reportables): ServiceResultInterface;
}
