<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

class CardUnblocked implements CardsReportable
{
    public function __toString(): string
    {
        return self::class;
    }

}
