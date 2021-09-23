<?php

namespace App\Contexts\Plans\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class PlanAdded extends BaseIntegrationEvent
{
    protected string $in = 'Plans';

    protected string $of = 'Plan';
}
