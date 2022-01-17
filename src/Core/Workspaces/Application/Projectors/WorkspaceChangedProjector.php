<?php

namespace Cardz\Core\Workspaces\Application\Projectors;

use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Domain\ReadModel\AddedWorkspace;
use Cardz\Core\Workspaces\Domain\ReadModel\Contracts\AddedWorkspaceStorageInterface;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;

final class WorkspaceChangedProjector implements EventConsumerInterface
{
    public function __construct(
        private AddedWorkspaceStorageInterface $addedWorkspaceStorage,
    ) {
    }

    public function consumes(): array
    {
        return [
            WorkspaceAdded::class,
            WorkspaceProfileChanged::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var Workspace $workspace */
        $workspace = $event->with();
        $this->addedWorkspaceStorage->persist(AddedWorkspace::of($workspace));
    }

}
