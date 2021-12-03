<?php

namespace Cardz\Core\Workspaces\Tests\Feature\Application\Commands;

use Cardz\Core\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use Cardz\Core\Workspaces\Tests\Feature\WorkspacesTestHelperTrait;
use Cardz\Core\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

final class ChangeWorkspaceProfileCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, WorkspacesTestHelperTrait;

    public function test_workspace_profile_can_be_changed()
    {
        $workspace = WorkspaceBuilder::make()->build();
        $this->getWorkspaceRepository()->persist($workspace);

        $command = ChangeWorkspaceProfile::of($workspace->workspaceId, 'Changed', 'Changed', 'Changed');
        $this->commandBus()->dispatch($command);

        $workspace = $this->getWorkspaceRepository()->take($command->getWorkspaceId());

        $this->assertEquals(
            ['name' => 'Changed', 'description' => 'Changed', 'address' => 'Changed'],
            $workspace->profile->toArray()
        );
        $this->assertEvent(WorkspaceProfileChanged::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
