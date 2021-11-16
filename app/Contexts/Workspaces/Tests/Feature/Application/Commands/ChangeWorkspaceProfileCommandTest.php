<?php

namespace App\Contexts\Workspaces\Tests\Feature\Application\Commands;

use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use App\Contexts\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use App\Contexts\Workspaces\Tests\Feature\WorkspacesTestHelperTrait;
use App\Contexts\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

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
