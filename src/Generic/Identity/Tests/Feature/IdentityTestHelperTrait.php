<?php

namespace Cardz\Generic\Identity\Tests\Feature;

use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Tests\Support\Mocks\UserInMemoryRepository;

trait IdentityTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserInMemoryRepository::class);
    }

    protected function getUserRepository(): UserRepositoryInterface
    {
        return $this->app->make(UserRepositoryInterface::class);
    }
}
