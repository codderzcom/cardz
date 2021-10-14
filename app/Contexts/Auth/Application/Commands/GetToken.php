<?php

namespace App\Contexts\Auth\Application\Commands;

final class GetToken implements GetTokenCommandInterface
{
    private function __construct(
        private string $identity,
        private string $password,
        private string $deviceName,
    ) {
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDeviceName(): string
    {
        return $this->deviceName;
    }
}
