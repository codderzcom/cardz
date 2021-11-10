<?php

namespace App\Contexts\MobileAppBack\Domain\ReadModel\Workspace;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class BusinessCard
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $cardId,
        public string $planId,
        public string $customerId,
        public ?Carbon $issued,
        public ?Carbon $satisfied,
        public ?Carbon $completed,
        public ?Carbon $revoked,
        public ?Carbon $blocked,
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
        ?Carbon $issued,
        ?Carbon $satisfied,
        ?Carbon $completed,
        ?Carbon $revoked,
        ?Carbon $blocked,
        array $achievements,
        array $requirements,
    ): self {
        return new self(
            $cardId,
            $planId,
            $customerId,
            $issued,
            $satisfied,
            $completed,
            $revoked,
            $blocked,
            $achievements,
            $requirements,
        );
    }
}
