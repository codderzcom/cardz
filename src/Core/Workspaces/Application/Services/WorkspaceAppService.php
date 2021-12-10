<?php

namespace Cardz\Core\Workspaces\Application\Services;

use Cardz\Core\Workspaces\Application\Commands\AddWorkspace;
use Cardz\Core\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use Cardz\Core\Workspaces\Application\Commands\RegisterKeeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Infrastructure\Messaging\DomainEventBusInterface;

class WorkspaceAppService
{
    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function registerKeeper(RegisterKeeper $command): KeeperId
    {
        $keeper = Keeper::register($command->getKeeperId());
        $events = $this->keeperRepository->store($keeper);
        $this->domainEventBus->publish(...$events);
        return $command->getKeeperId();
    }

    public function add(AddWorkspace $command): WorkspaceId
    {
        $keeper = $this->keeperRepository->restore($command->getKeeperId());
        return $this->release($keeper->keepWorkspace($command->getWorkspaceId(), $command->getProfile()));
    }

    public function changeProfile(ChangeWorkspaceProfile $command): WorkspaceId
    {
        $workspace = $this->workspaceRepository->restore($command->getWorkspaceId());
        return $this->release($workspace->changeProfile($command->getProfile()));
    }

    private function release(Workspace $workspace): WorkspaceId
    {
        $events = $this->workspaceRepository->store($workspace);
        $this->domainEventBus->publish(...$events);
        return $workspace->workspaceId;
    }
}
