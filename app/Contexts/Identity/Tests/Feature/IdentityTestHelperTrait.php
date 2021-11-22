<?php

namespace App\Contexts\Identity\Tests\Feature;

use App\Contexts\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Identity\Tests\Support\Mocks\UserInMemoryRepository;

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
