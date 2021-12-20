<?php

namespace App\OpenApi\Schemas;

use Codderz\Platypus\Infrastructure\Support\FakerTrait;

trait SchemaFakerTrait
{
    use FakerTrait;

    protected function text(int $symbols = 200): string
    {
        return $this->faker()->text($symbols);
    }

    protected function name(): string
    {
        return $this->faker()->name();
    }

    protected function company(): string
    {
        return $this->faker()->company();
    }

    protected function address(): string
    {
        return $this->faker()->address();
    }

    protected function login(): string
    {
        return $this->faker()->userName();
    }

    protected function word(): string
    {
        return $this->faker()->word();
    }

    protected function password(): string
    {
        return $this->faker()->password();
    }

    protected function email(): string
    {
        return $this->faker()->email();
    }

    protected function phone(): string
    {
        return $this->faker()->phoneNumber();
    }
}
