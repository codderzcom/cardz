<?php

namespace Cardz\Generic\Authorization\Infrastructure\ObjectProviders;

use Codderz\Platypus\Infrastructure\Authorization\Abac\Attributes;

interface ConcreteObjectProviderInterface
{
    public function reconstruct(): Attributes;
}
