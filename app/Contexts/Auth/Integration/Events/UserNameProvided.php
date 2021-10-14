<?php

namespace App\Contexts\Auth\Integration\Events;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class UserNameProvided extends BaseIntegrationEvent
{
    protected string $in = 'Auth';

    protected string $of = 'User';
}
