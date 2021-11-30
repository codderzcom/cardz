<?php

namespace Cardz\Support\MobileAppGateway\Integration\Contracts;

interface CollaborationContextInterface
{
    public function propose(string $collaboratorId, string $workspaceId): string;

    public function accept(string $inviteId, string $collaboratorId): string;

    public function discard(string $inviteId): string;

    public function leave(string $collaboratorId, string $workspaceId): string;
}
