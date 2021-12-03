<?php

namespace Cardz\Support\MobileAppGateway\Tests\Shared\Fixtures;

use Faker\Factory;

class UserLoginInfo
{
    protected function __construct(
        public string $id,
        public string $identity,
        public string $password,
        public string $deviceName,
    ) {
    }

    public static function of(string $id, string $identity, string $password): static
    {
        $deviceName = Factory::create()->word();
        return new static($id, $identity, $password, $deviceName);
    }
}
