<?php

namespace Cardz\Core\Workspaces\Integration\Events;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class WorkspaceChanged implements IntegrationEventInterface
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
