<?php

namespace Cardz\Core\Personal\Tests\Feature;

use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonStoreInterface;
use Cardz\Core\Personal\Infrastructure\ReadStorage\Contracts\JoinedPersonStorageInterface;
use Cardz\Core\Personal\Tests\Support\Mocks\PersonInMemoryStore;

trait PersonalTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(PersonStoreInterface::class, PersonInMemoryStore::class);
    }

    protected function getPersonStore(): PersonStoreInterface
    {
        return $this->app->make(PersonStoreInterface::class);
    }

    protected function getJoinedPersonStorage(): JoinedPersonStorageInterface
    {
        return $this->app->make(JoinedPersonStorageInterface::class);
    }
}
