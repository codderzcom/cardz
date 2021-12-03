<?php

namespace Cardz\Core\Cards\Domain\Model\Card;

use Codderz\Platypus\Contracts\Domain\ValueObjectInterface;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Description implements ValueObjectInterface
{
    use ArrayPresenterTrait;

    private function __construct(private string $description)
    {
    }

    #[Pure]
    public static function of(string $description): self
    {
        return new self($description);
    }

    public function __toString(): string
    {
        return $this->description;
    }
}
