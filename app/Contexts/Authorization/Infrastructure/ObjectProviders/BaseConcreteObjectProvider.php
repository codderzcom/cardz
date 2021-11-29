<?php

namespace App\Contexts\Authorization\Infrastructure\ObjectProviders;

use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Authorization\Abac\Attributes;

abstract class BaseConcreteObjectProvider implements ConcreteObjectProviderInterface
{
    protected function __construct(protected ?string $objectId)
    {
    }

    public static function of(?GeneralIdInterface $objectId)
    {
        return new static($objectId ? (string) $objectId : null);
    }

    public function reconstruct(): Attributes
    {
        return Attributes::of($this->getAttributes());
    }

    abstract protected function getAttributes(): array;
}
