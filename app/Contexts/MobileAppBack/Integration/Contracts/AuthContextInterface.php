<?php

namespace App\Contexts\MobileAppBack\Integration\Contracts;

interface AuthContextInterface
{
    public function registerUser(?string $email, ?string $phone, string $name, string $password, string $deviceName): string;

    public function issueToken(string $identity, string $password, string $deviceName): string;
}
