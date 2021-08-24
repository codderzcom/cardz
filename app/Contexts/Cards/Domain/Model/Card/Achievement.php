<?php

namespace App\Contexts\Cards\Domain\Model\Card;

class Achievement
{
    private function __construct(
        public AchievementId $achievementId
    ) {
    }
}
