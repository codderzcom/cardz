<?php

namespace App\Contexts\Workspaces\Application\Services;

use App\Contexts\Workspaces\Application\Commands\AddWorkspaceCommandInterface;
use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfileCommandInterface;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Workspaces\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Shared\Infrastructure\CommandHandling\CommandHandlerFactoryTrait;

class WorkspaceAppService
{
    use CommandHandlerFactoryTrait;

    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function add(AddWorkspaceCommandInterface $command): WorkspaceId
    {
        $keeper = $this->keeperRepository->take($command->getKeeperId());
        return $this->release($keeper->keepWorkspace($command->getWorkspaceId(), $command->getProfile()));
    }

    public function changeProfile(ChangeWorkspaceProfileCommandInterface $command): WorkspaceId
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
