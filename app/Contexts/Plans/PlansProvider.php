<?php

namespace App\Contexts\Plans;

use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class PlansProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(ReportingBusInterface $reportingBus)
    {
    }
}
