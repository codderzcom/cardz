<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Model\Entity;

final class Achievement extends Entity
{
    private function __construct(
        public AchievementId $achievementId,
        public string $description
    ) {
    }

}

