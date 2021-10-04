<?php

namespace App\Contexts\Collaboration;

use App\Contexts\Collaboration\Application\Contracts\AcceptedInviteReadStorageInterface;
use App\Contexts\Collaboration\Application\Contracts\AddedWorkspaceReadStorageInterface;
use App\Contexts\Collaboration\Application\Contracts\EnteredRelationReadStorageInterface;
use App\Contexts\Collaboration\Application\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Application\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Application\Contracts\MemberRepositoryInterface;
use App\Contexts\Collaboration\Application\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Application\Controllers\Consumers\InviteAcceptedConsumer;
use App\Contexts\Collaboration\Application\Controllers\Consumers\RelationEnteredConsumer;
use App\Contexts\Collaboration\Application\Controllers\Consumers\WorkspacesNewWorkspaceRegisteredConsumer;
use App\Contexts\Collaboration\Application\Controllers\Consumers\WorkspacesWorkspaceAddedConsumer;
use App\Contexts\Collaboration\Infrastructure\Persistence\InviteRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\KeeperRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\MemberRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\RelationRepository;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\AcceptedInviteReadStorage;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\AddedWorkspaceReadStorage;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\EnteredRelationReadStorage;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use App\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class CollaborationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(InviteRepositoryInterface::class, InviteRepository::class);
        $this->app->singleton(RelationRepositoryInterface::class, RelationRepository::class);
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperRepository::class);
        $this->app->singleton(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->singleton(AddedWorkspaceReadStorageInterface::class, AddedWorkspaceReadStorage::class);
        $this->app->singleton(AcceptedInviteReadStorageInterface::class, AcceptedInviteReadStorage::class);
        $this->app->singleton(EnteredRelationReadStorageInterface::class, EnteredRelationReadStorage::class);
    }

    public function boot(
        ReportingBusInterface $reportingBus,
        IntegrationEventBusInterface $integrationEventBus,
    )
    {
        $reportingBus->subscribe($this->app->make(InviteAcceptedConsumer::class));
        $reportingBus->subscribe($this->app->make(RelationEnteredConsumer::class));
        $reportingBus->subscribe($this->app->make(WorkspacesWorkspaceAddedConsumer::class));

        $integrationEventBus->subscribe($this->app->make(WorkspacesNewWorkspaceRegisteredConsumer::class));
    }
}
