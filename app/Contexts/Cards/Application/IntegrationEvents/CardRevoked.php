<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

class CardRevoked implements CardsReportable
{
    public function __toString(): string
    {
        return self::class;
    }

}
