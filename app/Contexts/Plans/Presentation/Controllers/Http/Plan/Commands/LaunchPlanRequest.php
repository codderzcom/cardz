<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Plan\Commands;

use App\Contexts\Plans\Application\Commands\Plan\LaunchPlan;
use App\Contexts\Plans\Application\Commands\Plan\LaunchPlanCommandInterface;

final class LaunchPlanRequest extends BaseCommandRequest
{
    public function toCommand(): LaunchPlanCommandInterface
    {
        return LaunchPlan::of($this->planId);
    }
}
