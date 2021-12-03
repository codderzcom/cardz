<?php

namespace Codderz\Platypus\Infrastructure\Support;

use ReflectionClass;

trait PropertiesExtractorTrait
{
    private function extractProperties(object $object, string ...$names): array
    {
        $reflection = new ReflectionClass($object);
        $properties = [];
        foreach ($names as $name) {
            if (!$reflection->hasProperty($name)) {
                continue;
            }
            $property = $reflection->getProperty($name);
            $property->setAccessible(true);
            $properties[$name] = $property->getValue($object);
        }
        return $properties;
    }

    private function extractProperty(object $object, string $name)
    {
        $reflection = new ReflectionClass($object);
        if (!$reflection->hasProperty($name)) {
            return null;
        }
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);
        return $property->getValue($object);
    }
}
