<?php

namespace App\Contexts\Workspaces\Tests\Feature\Application\Commands;

use App\Contexts\Workspaces\Application\Commands\AddWorkspace;
use App\Contexts\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Tests\Feature\WorkspacesTestHelperTrait;
use App\Contexts\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

final class AddWorkspaceCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, WorkspacesTestHelperTrait;

    public function test_workspace_can_be_added()
    {
        $profileTemplate = WorkspaceBuilder::make()->build()->profile;

        $command = AddWorkspace::of(KeeperId::makeValue(), ...$profileTemplate->toArray());
        $this->commandBus()->dispatch($command);

        $workspace = $this->getWorkspaceRepository()->take($command->getWorkspaceId());

        $this->assertSame((string) $workspace->workspaceId, (string) $command->getWorkspaceId());
        $this->assertEvent(WorkspaceAdded::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
