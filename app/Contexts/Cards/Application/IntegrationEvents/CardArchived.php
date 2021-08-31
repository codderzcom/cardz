<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class CardArchived extends BaseIntegrationEvent
{
    protected ?string $instanceOf = 'Card';
}
