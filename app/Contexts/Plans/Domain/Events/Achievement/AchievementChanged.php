<?php

namespace App\Contexts\Plans\Domain\Events\Achievement;

use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class AchievementChanged extends BaseAchievementDomainEvent
{
    public static function with(AchievementId $achievementId): self
    {
        return new self($achievementId);
    }
}
