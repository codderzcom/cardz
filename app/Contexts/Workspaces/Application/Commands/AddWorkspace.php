<?php

namespace App\Contexts\Workspaces\Application\Commands;

use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Commands\CommandInterface;

final class AddWorkspace implements CommandInterface
{
    private function __construct(
        private string $workspaceId,
        private string $keeperId,
        private string $name,
        private string $description,
        private string $address,
    ) {
    }

    public static function of(string $keeperId, string $name, string $description, string $address): self
    {
        return new self(WorkspaceId::makeValue(), $keeperId, $name, $description, $address);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

    public function getKeeperId(): KeeperId
    {
        return KeeperId::of($this->keeperId);
    }

    public function getProfile(): Profile
    {
        return Profile::of($this->name, $this->description, $this->address);
    }

}
