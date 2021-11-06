<?php

namespace App\Contexts\Authorization\Infrastructure\ObjectProviders;

use App\Shared\Infrastructure\Authorization\Abac\Attributes;

abstract class BaseConcreteObjectProvider implements ConcreteObjectProviderInterface
{
    protected function __construct(protected string $objectId)
    {
    }

    public static function of(string $objectId)
    {
        return new static($objectId);
    }

    public function reconstruct(): Attributes
    {
        return Attributes::of($this->getAttributes());
    }

    abstract protected function getAttributes(): array;
}
