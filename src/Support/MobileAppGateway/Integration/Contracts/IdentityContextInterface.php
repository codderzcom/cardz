<?php

namespace Cardz\Support\MobileAppGateway\Integration\Contracts;

interface IdentityContextInterface
{
    public function registerUser(?string $email, ?string $phone, string $name, string $password): string;

    public function getToken(string $identity, string $password, string $deviceName): string;

    public function clearTokens(string $userId): string;
}
