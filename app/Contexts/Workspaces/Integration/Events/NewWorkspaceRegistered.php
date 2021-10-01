<?php

namespace App\Contexts\Workspaces\Integration\Events;

use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Infrastructure\Support\ShortClassNameTrait;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class NewWorkspaceRegistered implements EventInterface
{
    use ShortClassNameTrait;

    private function __construct(
        private string $workspaceId,
        private array $payload = [],
    ) {
    }

    public static function of(Workspace $workspace): self
    {
        return new self((string) $workspace->workspaceId, $workspace->profile->toArray());
    }

    public function __toString()
    {
        return $this::shortName();
    }

    public function jsonSerialize()
    {
        return [
            'workspaceId' => $this->workspaceId,
            'payload' => $this->payload,
        ];
    }

}
