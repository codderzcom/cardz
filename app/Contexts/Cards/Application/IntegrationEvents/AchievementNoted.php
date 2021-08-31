<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class AchievementNoted extends BaseIntegrationEvent
{
    protected ?string $instanceOf = 'Card';
}
