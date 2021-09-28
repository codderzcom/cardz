<?php

namespace App\Contexts\Workspaces;

use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Workspaces\Application\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Application\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Application\Controllers\Consumers\WorkspaceAddedConsumer;
use App\Contexts\Workspaces\Infrastructure\Persistence\KeeperRepository;
use App\Contexts\Workspaces\Infrastructure\Persistence\WorkspaceRepository;
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
