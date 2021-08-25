<?php

namespace App\Contexts\Cards\Domain\Model;

use ReflectionClass;
use ReflectionMethod;

abstract class AggregateRoot extends Entity
{
    protected function getChildConstructor(string $childClass): ?ReflectionMethod
    {
        $reflection = new ReflectionClass($childClass);
        return $reflection->getConstructor();
    }
}
