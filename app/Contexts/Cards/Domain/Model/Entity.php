<?php

namespace App\Contexts\Cards\Domain\Model;

use App\Contexts\Cards\Domain\Persistable;
use ReflectionClass;

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
            $array[$property->getName()] = $property->getValue($this);
        }
        return $array;
    }

}
