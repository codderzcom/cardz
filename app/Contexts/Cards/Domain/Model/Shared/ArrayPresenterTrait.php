<?php

namespace App\Contexts\Cards\Domain\Model\Shared;

use Carbon\Carbon;
use ReflectionClass;
use Stringable;

trait ArrayPresenterTrait
{
    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass($this);
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $this->toArrayNestedValue($property->getValue($this));
        }
        return $array;
    }

    protected function toArrayNestedValue($value): mixed
    {
        return match (true) {
            $value instanceof Carbon => $value,
            $value instanceof Stringable => (string) $value,
            is_object($value) && method_exists($value, 'toArray') => $value->toArray(),
            default => $value,
        };
    }

}
