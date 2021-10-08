<?php

namespace App\Contexts\Cards\Integration\Events;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class CardRevoked extends BaseIntegrationEvent
{
    protected string $in = 'Cards';

    protected string $of = 'Card';
}
