<?php

namespace App\Shared\Infrastructure\Authorization\Abac;

use Illuminate\Support\Collection;

class Attributes extends Collection
{
    public static function of(array $attributes): static
    {
        return new static($attributes);
    }
}
