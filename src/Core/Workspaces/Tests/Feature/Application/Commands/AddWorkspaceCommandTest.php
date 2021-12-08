<?php

namespace Cardz\Core\Workspaces\Tests\Feature\Application\Commands;

use Cardz\Core\Workspaces\Application\Commands\AddWorkspace;
use Cardz\Core\Workspaces\Application\Commands\RegisterKeeper;
use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Cardz\Core\Workspaces\Tests\Feature\WorkspacesTestHelperTrait;
use Cardz\Core\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

final class AddWorkspaceCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, WorkspacesTestHelperTrait;

    public function test_workspace_can_be_added()
    {
        $keeperId = KeeperId::make();

        $command = RegisterKeeper::of($keeperId);
        $this->commandBus()->dispatch($command);

        $profileTemplate = WorkspaceBuilder::make()->build()->profile;
        $command = AddWorkspace::of($keeperId, ...$profileTemplate->toArray());
        $this->commandBus()->dispatch($command);

        $workspace = $this->getWorkspaceRepository()->take($command->getWorkspaceId());

        $this->assertEquals($command->getWorkspaceId(), $workspace->workspaceId);
        $this->assertEquals($command->getKeeperId(), $workspace->keeperId);
        $this->assertEvent(WorkspaceAdded::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
