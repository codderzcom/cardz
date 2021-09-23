<?php

namespace App\Contexts\Collaboration;

use App\Contexts\Collaboration\Application\Contracts\AddedWorkspaceReadStorageInterface;
use App\Contexts\Collaboration\Application\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Application\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Application\Controllers\Consumers\WorkspacesWorkspaceAddedConsumer;
use App\Contexts\Collaboration\Infrastructure\Persistence\InviteRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\RelationRepository;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\AddedWorkspaceReadStorage;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class CollaborationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(InviteRepositoryInterface::class, InviteRepository::class);
        $this->app->singleton(RelationRepositoryInterface::class, RelationRepository::class);
        $this->app->singleton(AddedWorkspaceReadStorageInterface::class, AddedWorkspaceReadStorage::class);
    }

    public function boot(ReportingBusInterface $reportingBus)
    {
        $reportingBus->subscribe($this->app->make(WorkspacesWorkspaceAddedConsumer::class));
    }
}
