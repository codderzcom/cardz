<?php

namespace App\Contexts\MobileAppBack;

use App\Contexts\MobileAppBack\Application\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Contracts\WorkspacePlanReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\CustomerWorkspaceReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\IssuedCardReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\BusinessWorkspaceReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\WorkspacePlanReadStorage;
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
