<?php

namespace App\Contexts\Workspaces\Tests\Feature\Application\Commands;

use App\Contexts\Workspaces\Application\Commands\AddWorkspace;
use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use App\Contexts\Workspaces\Application\Services\WorkspaceAppService;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Tests\Support\Mocks\KeeperInMemoryRepository;
use App\Contexts\Workspaces\Tests\Support\Mocks\WorkspaceInMemoryRepository;
use App\Contexts\Workspaces\Tests\Support\WorkspaceBuilder;
use App\Shared\Infrastructure\CommandHandling\SimpleAutoCommandHandlerProvider;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

final class AddWorkspaceCommandTest extends BaseTestCase
{
    use ApplicationTestTrait;

    public function test_workspace_can_be_added()
    {
        $profileTemplate = WorkspaceBuilder::make()->build()->profile;

        $command = AddWorkspace::of(KeeperId::makeValue(), ...$profileTemplate->toArray());
        $this->commandBus()->dispatch($command);

        $workspace = $this->getWorkspaceRepository()->take($command->getWorkspaceId());

        $this->assertSame((string) $workspace->workspaceId, (string) $command->getWorkspaceId());
    }

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
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceInMemoryRepository::class);
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperInMemoryRepository::class);
        $this->commandBus()->registerProvider(SimpleAutoCommandHandlerProvider::parse(
            $this->app->make(WorkspaceAppService::class)
        ));
    }

    protected function getWorkspaceRepository(): WorkspaceRepositoryInterface
    {
        return $this->app->make(WorkspaceRepositoryInterface::class);
    }
}
