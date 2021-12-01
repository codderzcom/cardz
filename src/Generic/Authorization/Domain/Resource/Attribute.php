<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeInterface;
use Codderz\Platypus\Exceptions\ParameterAssertionException;

final class Attribute implements AttributeInterface
{
    public function __construct(
        private string $name,
        private $value,
    ) {
    }

    public static function of(string $name, $value): self
    {
        return new self($name, $value);
    }

    public static function fromArray($attribute): self
    {
        if (!is_array($attribute)) {
            throw new ParameterAssertionException("Unknown attribute data format");
        }
        return self::of(
            $attribute[0] ?? throw new ParameterAssertionException("Attribute name missing"),
            $attribute[1] ?? null,
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}
