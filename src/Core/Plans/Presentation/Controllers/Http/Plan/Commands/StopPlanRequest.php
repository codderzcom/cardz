<?php

namespace Cardz\Core\Plans\Presentation\Controllers\Http\Plan\Commands;

use Cardz\Core\Plans\Application\Commands\Plan\StopPlan;

final class StopPlanRequest extends BaseCommandRequest
{
    public function toCommand(): StopPlan
    {
        return StopPlan::of($this->planId);
    }
}
