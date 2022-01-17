<?php

namespace Cardz\Core\Workspaces\Application\Commands;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Profile;
use Cardz\Core\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;
use JetBrains\PhpStorm\Pure;

final class ChangeWorkspaceProfile implements CommandInterface
{
    private function __construct(
        private string $workspaceId,
        private string $name,
        private string $description,
        private string $address,
    ) {
    }

    #[Pure]
    public static function of(string $workspaceId, string $name, string $description, string $address): self
    {
        return new self($workspaceId, $name, $description, $address);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

    #[Pure]
    public function getProfile(): Profile
    {
        return Profile::of($this->name, $this->description, $this->address);
    }

}
