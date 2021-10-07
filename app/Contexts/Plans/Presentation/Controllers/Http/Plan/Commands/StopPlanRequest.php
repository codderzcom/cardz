<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Plan\Commands;

use App\Contexts\Plans\Application\Commands\Plan\StopPlan;
use App\Contexts\Plans\Application\Commands\Plan\StopPlanCommandInterface;

final class StopPlanRequest extends BaseCommandRequest
{
    public function toCommand(): StopPlanCommandInterface
    {
        return StopPlan::of($this->planId);
    }
}
