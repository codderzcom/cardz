<?php

namespace App\Contexts\MobileAppBack;

use App\Contexts\MobileAppBack\Application\Services\AuthorizationService;
use App\Contexts\MobileAppBack\Application\Services\AuthorizationServiceInterface;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\MonolithCardsAdapter;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Collaboration\MonolithCollaborationAdapter;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Identity\MonolithIdentityAdapter;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Plans\MonolithPlansAdapter;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Workspaces\MonolithWorkspacesAdapter;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Eloquent\CustomerWorkspaceReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Eloquent\IssuedCardReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessCardReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessPlanReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent\BusinessCardReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent\BusinessPlanReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent\BusinessWorkspaceReadStorage;
use App\Contexts\MobileAppBack\Integration\Contracts\IdentityContextInterface;
use App\Contexts\MobileAppBack\Integration\Contracts\CardsContextInterface;
use App\Contexts\MobileAppBack\Integration\Contracts\CollaborationContextInterface;
use App\Contexts\MobileAppBack\Integration\Contracts\PlansContextInterface;
use App\Contexts\MobileAppBack\Integration\Contracts\WorkspacesContextInterface;
use Illuminate\Support\ServiceProvider;

class MobileAppBackProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IssuedCardReadStorageInterface::class, IssuedCardReadStorage::class);
        $this->app->singleton(CustomerWorkspaceReadStorageInterface::class, CustomerWorkspaceReadStorage::class);
        $this->app->singleton(BusinessCardReadStorageInterface::class, BusinessCardReadStorage::class);
        $this->app->singleton(BusinessPlanReadStorageInterface::class, BusinessPlanReadStorage::class);
        $this->app->singleton(BusinessWorkspaceReadStorageInterface::class, BusinessWorkspaceReadStorage::class);

        $this->app->singleton(AuthorizationServiceInterface::class, AuthorizationService::class);


        $this->app->singleton(IdentityContextInterface::class, MonolithIdentityAdapter::class);
        $this->app->singleton(CardsContextInterface::class, MonolithCardsAdapter::class);
        $this->app->singleton(CollaborationContextInterface::class, MonolithCollaborationAdapter::class);
        $this->app->singleton(PlansContextInterface::class, MonolithPlansAdapter::class);
        $this->app->singleton(WorkspacesContextInterface::class, MonolithWorkspacesAdapter::class);
    }

    public function boot()
    {
    }
}
