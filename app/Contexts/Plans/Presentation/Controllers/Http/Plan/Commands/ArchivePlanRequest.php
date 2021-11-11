<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Plan\Commands;

use App\Contexts\Plans\Application\Commands\Plan\ArchivePlan;

final class ArchivePlanRequest extends BaseCommandRequest
{
    public function toCommand(): ArchivePlan
    {
        return ArchivePlan::of($this->planId);
    }
}
