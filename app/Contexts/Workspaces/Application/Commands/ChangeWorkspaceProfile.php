<?php

namespace App\Contexts\Workspaces\Application\Commands;

use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;

final class ChangeWorkspaceProfile implements ChangeWorkspaceProfileCommandInterface
{
    private function __construct(
        private string $workspaceId,
        private string $name,
        private string $description,
        private string $address,
    ) {
    }

    public static function of(string $workspaceId, string $name, string $description, string $address): self
    {
        return new self($workspaceId, $name, $description, $address);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

    public function getProfile(): Profile
    {
        return Profile::of($this->name, $this->description, $this->address);
    }

}
