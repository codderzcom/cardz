<?php

namespace App\Contexts\Plans\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class PlanStopped extends BaseIntegrationEvent
{
    protected ?string $instanceOf = 'Plan';
}
