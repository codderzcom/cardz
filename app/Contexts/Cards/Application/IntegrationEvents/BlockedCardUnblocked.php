<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class BlockedCardUnblocked extends BaseIntegrationEvent
{
    protected ?string $instanceOf = 'BlockedCard';
}
