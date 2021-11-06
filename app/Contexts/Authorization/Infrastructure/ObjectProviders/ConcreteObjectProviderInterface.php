<?php

namespace App\Contexts\Authorization\Infrastructure\ObjectProviders;

use App\Shared\Infrastructure\Authorization\Abac\Attributes;

interface ConcreteObjectProviderInterface
{
    public function reconstruct(): Attributes;
}
