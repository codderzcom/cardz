<?php

namespace App\Contexts\Workspaces\Application\Commands;

use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Commands\CommandInterface;

interface AddWorkspaceCommandInterface extends CommandInterface
{
    public function getWorkspaceId(): WorkspaceId;

    public function getKeeperId(): KeeperId;

    public function getProfile(): Profile;

}
