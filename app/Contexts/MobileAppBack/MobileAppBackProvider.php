<?php

namespace App\Contexts\MobileAppBack;

use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Eloquent\CustomerWorkspaceReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Eloquent\IssuedCardReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\WorkspacePlanReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent\BusinessWorkspaceReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent\WorkspacePlanReadStorage;
use Illuminate\Support\ServiceProvider;

class MobileAppBackProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IssuedCardReadStorageInterface::class, IssuedCardReadStorage::class);
        $this->app->singleton(CustomerWorkspaceReadStorageInterface::class, CustomerWorkspaceReadStorage::class);
        $this->app->singleton(BusinessWorkspaceReadStorageInterface::class, BusinessWorkspaceReadStorage::class);
        $this->app->singleton(WorkspacePlanReadStorageInterface::class, WorkspacePlanReadStorage::class);
    }
}
