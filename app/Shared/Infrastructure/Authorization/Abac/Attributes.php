<?php

namespace App\Shared\Infrastructure\Authorization\Abac;

use App\Shared\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Illuminate\Support\Collection;

class Attributes extends Collection implements AttributeCollectionInterface
{
    public static function of(array $attributes): static
    {
        return new static($attributes);
    }
}
