<?php

namespace App\Contexts\Cards\Domain\ReadModel;

use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;

final class IssuedCard
{
    use ArrayPresenterTrait;

    private array $statefulRequirements;

    private function __construct(
        private string $cardId,
        private string $planId,
        private string $customerId,
        private bool $satisfied,
        private bool $completed,
        private bool $revoked,
        private bool $blocked,
        StatefulRequirement ...$statefulRequirements,
    ) {
        $this->statefulRequirements = $statefulRequirements;
    }

    public static function make(
        string $cardId,
        string $planId,
        string $customerId,
        bool $satisfied,
        bool $completed,
        bool $revoked,
        bool $blocked,
        StatefulRequirement ...$statefulRequirements,
    ): self {
        return new self(
            $cardId,
            $planId,
            $customerId,
            $satisfied,
            $completed,
            $revoked,
            $blocked,
            ...$statefulRequirements,
        );
    }
}
