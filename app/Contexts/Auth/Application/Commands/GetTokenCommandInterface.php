<?php

namespace App\Contexts\Auth\Application\Commands;

interface GetTokenCommandInterface
{
    public function getIdentity(): string;

    public function getPassword(): string;

    public function getDeviceName(): string;
}
