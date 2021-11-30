<?php

namespace Codderz\Platypus\Infrastructure\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Illuminate\Support\Collection;

class Attributes extends Collection implements AttributeCollectionInterface
{
    public static function of(array $attributes): static
    {
        return new static($attributes);
    }
}
