<?php

namespace Cardz\Core\Plans\Presentation\Controllers\Http\Plan\Commands;

use Cardz\Core\Plans\Application\Commands\Plan\LaunchPlan;

final class LaunchPlanRequest extends BaseCommandRequest
{
    public function toCommand(): LaunchPlan
    {
        return LaunchPlan::of($this->planId);
    }
}
