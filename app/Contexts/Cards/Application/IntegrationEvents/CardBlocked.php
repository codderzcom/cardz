<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

class CardBlocked implements CardsReportable
{
    public function __toString(): string
    {
        return self::class;
    }

}
