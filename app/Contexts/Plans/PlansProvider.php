<?php

namespace App\Contexts\Plans;

use App\Contexts\Plans\Application\Contracts\AchievementRepositoryInterface;
use App\Contexts\Plans\Application\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Application\Controllers\Consumers\PlanAddedConsumer;
use App\Contexts\Plans\Infrastructure\Persistence\AchievementRepository;
use App\Contexts\Plans\Infrastructure\Persistence\PlanRepository;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class PlansProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->singleton(AchievementRepositoryInterface::class, AchievementRepository::class);
    }

    public function boot(ReportingBusInterface $reportingBus)
    {
        $reportingBus->subscribe($this->app->make(PlanAddedConsumer::class));
    }
}
