<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class CardSatisfactionWithdrawn extends BaseIntegrationEvent
{
    protected ?string $instanceOf = 'Card';
}
