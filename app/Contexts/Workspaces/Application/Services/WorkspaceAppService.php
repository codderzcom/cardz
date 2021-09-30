<?php

namespace App\Contexts\Workspaces\Application\Services;

use App\Contexts\Workspaces\Application\Commands\AddWorkspaceCommandInterface;
use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfileCommandInterface;
use App\Contexts\Workspaces\Application\Exceptions\KeeperNotFoundException;
use App\Contexts\Workspaces\Application\Exceptions\WorkspaceNotFoundException;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Workspaces\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Infrastructure\CommandHandling\CommandHandlerFactoryTrait;

class WorkspaceAppService
{
    use CommandHandlerFactoryTrait;

    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private DomainEventBusInterface $domainEventBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function registerHandlers(): void
    {
        $this->commandBus->registerHandlers(
            $this->makeHandlerFor(AddWorkspaceCommandInterface::class, 'add'),
            $this->makeHandlerFor(ChangeWorkspaceProfileCommandInterface::class, 'changeProfile'),
        );
    }

    /**
     * @throws KeeperNotFoundException
     */
    public function add(AddWorkspaceCommandInterface $command): WorkspaceId
    {
        $keeper = $this->keeperRepository->take($command->getKeeperId());
        if ($keeper === null) {
            throw new KeeperNotFoundException("Keeper id {$command->getKeeperId()}");
        }

        $workspace = $keeper->keepWorkspace($command->getWorkspaceId(), $command->getProfile());
        $this->releaseWorkspace($workspace);

        return $workspace->workspaceId;
    }

    public function changeProfile(ChangeWorkspaceProfileCommandInterface $command): WorkspaceId
    {
        $workspace = $this->workspaceRepository->take($command->getWorkspaceId());
        if ($workspace === null) {
            throw new WorkspaceNotFoundException("Workspace id {$command->getWorkspaceId()}");
        }

        $workspace->changeProfile($command->getProfile());
        $this->releaseWorkspace($workspace);

        return $workspace->workspaceId;
    }

    private function releaseWorkspace(Workspace $workspace): void
    {
        $this->workspaceRepository->persist($workspace);
        $this->domainEventBus->publish(...$workspace->releaseEvents());
    }
}
