<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

class CardIssued implements CardsReportable
{
    public function __toString(): string
    {
        return self::class;
    }

}
