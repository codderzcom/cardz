<?php

namespace App\Contexts\Personal\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class PersonJoined extends BaseIntegrationEvent
{
    protected ?string $instanceOf = 'Person';
}
