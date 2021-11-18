<?php

namespace App\Contexts\Personal\Tests\Feature;

use App\Contexts\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use App\Contexts\Personal\Tests\Support\Mocks\PersonInMemoryRepository;

trait PersonalTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(PersonRepositoryInterface::class, PersonInMemoryRepository::class);
    }

    protected function getPersonRepository(): PersonRepositoryInterface
    {
        return $this->app->make(PersonRepositoryInterface::class);
    }
}
