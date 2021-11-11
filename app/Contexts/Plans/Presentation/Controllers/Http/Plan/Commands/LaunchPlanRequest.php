<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Plan\Commands;

use App\Contexts\Plans\Application\Commands\Plan\LaunchPlan;

final class LaunchPlanRequest extends BaseCommandRequest
{
    public function toCommand(): LaunchPlan
    {
        return LaunchPlan::of($this->planId);
    }
}
