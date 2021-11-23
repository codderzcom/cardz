<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Fixtures;

class Environment
{
    public static function of(): static
    {
        return new static();
    }
}
