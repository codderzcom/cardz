<?php

namespace App\Contexts\Workspaces\Application\Services;

use App\Contexts\Workspaces\Application\Commands\AddWorkspace;
use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Messaging\DomainEventBusInterface;

class WorkspaceAppService
{
    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function add(AddWorkspace $command): WorkspaceId
    {
        $keeper = $this->keeperRepository->take($command->getKeeperId());
        return $this->release($keeper->keepWorkspace($command->getWorkspaceId(), $command->getProfile()));
    }

    public function changeProfile(ChangeWorkspaceProfile $command): WorkspaceId
    {
        $workspace = $this->workspaceRepository->take($command->getWorkspaceId());
        return $this->release($workspace->changeProfile($command->getProfile()));
    }

    private function release(Workspace $workspace): WorkspaceId
    {
        $this->workspaceRepository->persist($workspace);
        $this->domainEventBus->publish(...$workspace->releaseEvents());
        return $workspace->workspaceId;
    }
}
