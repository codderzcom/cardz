<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Fixtures;

class UserLoginInfo
{
    protected function __construct(
        public string $id,
        public string $identity,
        public string $password,
    ) {
    }

    public static function of(string $id, string $identity, string $password): static
    {
        return new static($id, $identity, $password);
    }
}
