<?php

namespace App\Contexts\Workspaces\Integration\Events;

use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Shared\Contracts\Messaging\IntegrationEventInterface;
use App\Shared\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class NewWorkspaceRegistered implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    private function __construct(
        private string $workspaceId,
        private array $payload = [],
    ) {
    }

    public static function of(Workspace $workspace): self
    {
        return new self((string) $workspace->workspaceId, $workspace->profile->toArray());
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'workspaceId' => $this->workspaceId,
            'payload' => $this->payload,
        ];
    }
}
