<?php

namespace App\Contexts\Cards\Application\Commands;

use App\Contexts\Cards\Domain\Model\Card\Achievement;

interface FixAchievementDescriptionCommandInterface extends CardCommandInterface
{
    public function getAchievement(): Achievement;
}
