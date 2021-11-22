<?php

namespace App\Contexts\Auth\Tests\Feature;

use App\Contexts\Auth\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Auth\Tests\Support\Mocks\UserInMemoryRepository;

trait AuthTestHelperTrait
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
