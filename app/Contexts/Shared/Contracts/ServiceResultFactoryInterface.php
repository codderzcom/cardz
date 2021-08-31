<?php

namespace App\Contexts\Shared\Contracts;

interface ServiceResultFactoryInterface
{
    public function ok(string $payload): ServiceResultInterface;

    public function violation(string $violation): ServiceResultInterface;

    public function error(string $error): ServiceResultInterface;

    public function notFound(): ServiceResultInterface;
}
