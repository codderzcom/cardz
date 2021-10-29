<?php

namespace App\Contexts\MobileAppBack;

use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerCommandService;
use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerQueryService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\CardAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\CollaborationAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\PlanAppService;
use App\Contexts\MobileAppBack\Application\Services\Workspace\WorkspaceAppService;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Eloquent\CustomerWorkspaceReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Eloquent\IssuedCardReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\WorkspacePlanReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent\BusinessWorkspaceReadStorage;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent\WorkspacePlanReadStorage;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Queries\QueryBusInterface;
use App\Shared\Infrastructure\CommandHandling\SimpleAutoCommandHandlerProvider;
use App\Shared\Infrastructure\QueryHandling\SimpleAutoQueryExecutorProvider;
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

    public function boot(
        QueryBusInterface $queryBus,
        CommandBusInterface $commandBus,
        CustomerCommandService $customerCommandService,
        CustomerQueryService $customerQueryService,
        CardAppService $cardAppService,
        CollaborationAppService $collaborationAppService,
        PlanAppService $planAppService,
        WorkspaceAppService $workspaceAppService,
    ) {
        $commandBus->registerProvider(SimpleAutoCommandHandlerProvider::parse(
            $customerCommandService, $cardAppService, $collaborationAppService, $planAppService, $workspaceAppService,
        ));

        $queryBus->registerProvider(SimpleAutoQueryExecutorProvider::parse(
            $customerQueryService, $cardAppService, $collaborationAppService, $planAppService, $workspaceAppService,
        ));
    }
}
