<?php

namespace App\Contexts\Collaboration\Integration\Events;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class InviteProposed extends BaseIntegrationEvent
{
    protected string $in = 'Collaboration';

    protected string $of = 'Invite';
}
