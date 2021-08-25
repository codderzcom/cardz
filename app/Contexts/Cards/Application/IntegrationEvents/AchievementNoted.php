<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

class AchievementNoted implements CardsReportable
{
    public function __toString(): string
    {
        return self::class;
    }

}
