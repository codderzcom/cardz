<?php

namespace App\Contexts\MobileAppBack\Application\Queries\Customer;

use App\Shared\Contracts\Queries\QueryInterface;

final class GetToken implements QueryInterface
{
    public function __construct(
        public string $identity,
        public string $password,
        public string $deviceName,
    ) {
    }

    public static function of(string $identity, string $password, string $devicename): self
    {
        return new self($identity, $password, $devicename);
    }
}
