<?php

namespace Cardz\Generic\Authorization\Infrastructure\ObjectProviders;

use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Infrastructure\Authorization\Abac\Attributes;

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
