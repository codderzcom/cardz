<?php

namespace Cardz\Support\Collaboration\Tests\Feature;

use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\Collaboration\Tests\Support\Mocks\InviteInMemoryRepository;
use Cardz\Support\Collaboration\Tests\Support\Mocks\RelationInMemoryRepository;

trait CollaborationTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(InviteRepositoryInterface::class, InviteInMemoryRepository::class);
        $this->app->singleton(RelationRepositoryInterface::class, RelationInMemoryRepository::class);
    }

    protected function getInviteRepository(): InviteRepositoryInterface
    {
        return $this->app->make(InviteRepositoryInterface::class);
    }

    protected function getRelationRepository(): RelationRepositoryInterface
    {
        return $this->app->make(RelationRepositoryInterface::class);
    }

    protected function getKeeperRepository(): KeeperRepositoryInterface
    {
        return $this->app->make(KeeperRepositoryInterface::class);
    }
}
