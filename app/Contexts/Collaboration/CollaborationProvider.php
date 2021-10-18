<?php

namespace App\Contexts\Collaboration;

use App\Contexts\Collaboration\Application\Controllers\Consumers\InviteAcceptedConsumer;
use App\Contexts\Collaboration\Application\Controllers\Consumers\RelationEnteredConsumer;
use App\Contexts\Collaboration\Application\Controllers\Consumers\WorkspacesWorkspaceAddedConsumer;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\MemberRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent\InviteRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent\KeeperRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent\MemberRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent\RelationRepository;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\AcceptedInviteReadStorageInterface;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\AddedWorkspaceReadStorageInterface;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\EnteredRelationReadStorageInterface;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Eloquent\AcceptedInviteReadStorage;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Eloquent\AddedWorkspaceReadStorage;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Eloquent\EnteredRelationReadStorage;
use App\Contexts\Collaboration\Integration\Consumers\WorkspacesNewWorkspaceRegisteredConsumer;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use App\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class CollaborationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);

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
