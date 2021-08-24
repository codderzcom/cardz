<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

class CardCompleted implements CardsReportable
{
    public function __toString(): string
    {
        return self::class;
    }

}
