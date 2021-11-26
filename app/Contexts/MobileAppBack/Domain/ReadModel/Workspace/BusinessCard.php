<?php

namespace App\Contexts\MobileAppBack\Domain\ReadModel\Workspace;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;

final class BusinessCard
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $cardId,
        public string $planId,
        public string $customerId,
        public bool $isIssued,
        public bool $isSatisfied,
        public bool $isCompleted,
        public bool $isRevoked,
        public bool $isBlocked,
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
        bool $isIssued,
        bool $isSatisfied,
        bool $isCompleted,
        bool $isRevoked,
        bool $isBlocked,
        array $achievements,
        array $requirements,
    ): self {
        return new self(
            $cardId,
            $planId,
            $customerId,
            $isIssued,
            $isSatisfied,
            $isCompleted,
            $isRevoked,
            $isBlocked,
            $achievements,
            $requirements,
        );
    }
}
