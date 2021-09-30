<?php

namespace App\Contexts\Workspaces\Application\Commands;

use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Commands\CommandInterface;

interface ChangeWorkspaceProfileCommandInterface extends CommandInterface
{
    public function getWorkspaceId(): WorkspaceId;

    public function getProfile(): Profile;

}
