<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

class BlockedCardUnblocked implements CardsReportable
{
    public function __toString(): string
    {
        return self::class;
    }

}
