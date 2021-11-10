<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Collaboration;

use App\Contexts\MobileAppBack\Integration\Contracts\CollaborationContextInterface;
use App\Shared\Contracts\Commands\CommandBusInterface;

class MonolithCollaborationAdapter implements CollaborationContextInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

}
