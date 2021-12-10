<?php

namespace Cardz\Core\Personal\Tests\Feature;

use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use Cardz\Core\Personal\Domain\ReadModel\Contracts\JoinedPersonStorageInterface;
use Cardz\Core\Personal\Tests\Support\Mocks\PersonInMemoryRepository;

trait PersonalTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(PersonRepositoryInterface::class, PersonInMemoryRepository::class);
    }

    protected function getPersonStore(): PersonRepositoryInterface
    {
        return $this->app->make(PersonRepositoryInterface::class);
    }

    protected function getJoinedPersonStorage(): JoinedPersonStorageInterface
    {
        return $this->app->make(JoinedPersonStorageInterface::class);
    }
}
