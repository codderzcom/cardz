<?php

namespace App\Contexts\MobileAppBack\Tests\Shared;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;

class CustomerDTO
{
    use ArrayPresenterTrait;

    public function __construct(
        public string $email,
        public string $phone,
        public string $name,
        public string $password,
        public string $deviceName,
    ) {
    }
}
