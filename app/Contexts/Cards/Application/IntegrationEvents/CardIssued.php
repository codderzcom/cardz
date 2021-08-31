<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class CardIssued extends BaseIntegrationEvent
{
    protected ?string $instanceOf = 'Card';
}
