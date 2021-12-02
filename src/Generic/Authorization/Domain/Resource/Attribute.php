<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeInterface;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final class Attribute implements AttributeInterface, JsonSerializable, Arrayable
{
    use ArrayPresenterTrait;

    public function __construct(
        private string $name,
        private $value,
    ) {
    }

    public static function of(string $name, $value): self
    {
        return new self($name, $value);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

}
