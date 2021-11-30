<?php

namespace Cardz\Generic\Identity\Application\Queries;

use Codderz\Platypus\Contracts\Queries\QueryInterface;

final class GetToken implements QueryInterface
{
    private function __construct(
        private string $identity,
        private string $password,
        private string $deviceName,
    ) {
        $this->identity = mb_strtolower($this->identity);
    }

    public static function of(string $identity, string $password, string $deviceName): self
    {
        return new self($identity, $password, $deviceName);
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
