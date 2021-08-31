<?php

namespace App\Contexts\Cards\Domain\Model;

use App\Contexts\Cards\Domain\Persistable;
use Carbon\Carbon;
use ReflectionClass;
use Stringable;

abstract class Entity implements Persistable
{
    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }

    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass($this);
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $this->nest($property->getValue($this));
        }
        return $array;
    }

    private function nest($value)
    {
        return match (true) {
            $value instanceof Carbon => $value,
            $value instanceof Stringable => (string) $value,
            is_object($value) && method_exists($value, 'toArray') => $value->toArray(),
            default => $value,
        };
    }

}
