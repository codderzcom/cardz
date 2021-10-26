<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Plan\Commands;

use App\Contexts\Plans\Application\Commands\Plan\StopPlan;

final class StopPlanRequest extends BaseCommandRequest
{
    public function toCommand(): StopPlan
    {
        return StopPlan::of($this->planId);
    }
}
