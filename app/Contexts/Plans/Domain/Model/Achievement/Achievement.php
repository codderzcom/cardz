<?php

namespace App\Contexts\Plans\Domain\Model\Achievement;

class Achievement
{
    public function __construct(
        public AchievementId $planId
    )
    {
    }
}
