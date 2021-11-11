<?php

namespace App\Contexts\MobileAppBack\Application\Commands\Customer;

use App\Shared\Contracts\Commands\CommandInterface;

final class RegisterCustomer implements CommandInterface
{
    private function __construct(
        public string $name,
        public string $password,
        public ?string $email,
        public ?string $phone,
    ) {
    }

    public static function of(string $name, string $password, ?string $email, ?string $phone): self
    {
        return new self($name, $password, $email, $phone);
    }
}
