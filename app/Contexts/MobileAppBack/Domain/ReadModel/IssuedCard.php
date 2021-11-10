<?php

namespace App\Contexts\MobileAppBack\Domain\ReadModel;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

final class IssuedCard implements JsonSerializable
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $cardId,
        public string $planId,
        public string $customerId,
        public bool $satisfied,
        public bool $completed,
        public array $achievements,
        public array $requirements,
    ) {
    }

    /**
     * @param string[] $achievements
     * @param string[] $requirements
     */
    #[Pure]
    public static function make(
        string $cardId,
        string $planId,
        string $customerId,
        bool $satisfied,
        bool $completed,
        array $achievements,
        array $requirements,
    ): self {
        return new self(
            $cardId,
            $planId,
            $customerId,
            $satisfied,
            $completed,
            $achievements,
            $requirements,
        );
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
