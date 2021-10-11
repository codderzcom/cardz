<?php

namespace App\Contexts\Cards\Application\Commands;

interface DismissAchievementCommandInterface extends CardCommandInterface
{
    public function getAchievementId(): string;
}
