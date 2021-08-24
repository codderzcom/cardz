<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

interface CardsReportable
{
    public function __toString(): string;
}
