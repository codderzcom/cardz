<?php

namespace App\Contexts\Collaboration\Integration\Events;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class RelationEntered extends BaseIntegrationEvent
{
    protected string $in = 'Collaboration';

    protected string $of = 'Relation';
}
