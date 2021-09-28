<?php

namespace App\Contexts\Workspaces;

use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Persistence\Eloquent\KeeperRepository;
use App\Contexts\Workspaces\Infrastructure\Persistence\Eloquent\WorkspaceRepository;
use App\Contexts\Workspaces\Integration\Consumers\WorkspaceAddedConsumer;
use App\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class WorkspacesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperRepository::class);
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceRepository::class);
    }

    public function boot(ReportingBusInterface $reportingBus)
    {
        $reportingBus->subscribe($this->app->make(WorkspaceAddedConsumer::class));
    }
}
