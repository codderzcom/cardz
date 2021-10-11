<?php

namespace App\Contexts\Cards\Domain\ReadModel;

use App\Contexts\Cards\Domain\Model\Card\Achievements;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;

final class IssuedCard
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $cardId,
        public string $planId,
        public string $customerId,
        public bool $satisfied,
        public bool $completed,
        public bool $revoked,
        public bool $blocked,
        public Achievements $achievements,
        public Achievements $requirements,
    ) {
    }

    #[Pure]
    public static function of(
        string $cardId,
        string $planId,
        string $customerId,
        bool $satisfied,
        bool $completed,
        bool $revoked,
        bool $blocked,
        Achievements $achievements,
        Achievements $requirements,
    ): self {
        return new self(
            $cardId,
            $planId,
            $customerId,
            $satisfied,
            $completed,
            $revoked,
            $blocked,
            $achievements,
            $requirements,
        );
    }

    #[Pure]
    public static function from(Card $card): self
    {
        return new self(
            (string) $card->cardId,
            (string) $card->planId,
            (string) $card->customerId,
            $card->isSatisfied(),
            $card->isCompleted(),
            $card->isRevoked(),
            $card->isBlocked(),
            $card->getAchievements(),
            $card->getRequirements(),
        );
    }
}
