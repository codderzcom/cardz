<?php

namespace App\Contexts\Cards\Domain\Model;

use App\Contexts\Cards\Domain\Persistable;
use ReflectionClass;
use Throwable;

abstract class Entity implements Persistable
{
    private function toArray(): array
    {
        $reflectionClass = new ReflectionClass($this);
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            if ($property->getValue($this) !== null) {
                $array[$property->getName()] = $property->getValue($this);
            }
        }
        return $array;
    }

    public function __toString(): string
    {
        try {
            return json_try_encode($this->toArray());
        } catch (Throwable $exception) {
            return '';
        }
    }


}
