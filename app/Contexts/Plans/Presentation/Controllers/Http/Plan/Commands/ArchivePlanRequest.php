<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Plan\Commands;

use App\Contexts\Plans\Application\Commands\Plan\ArchivePlan;
use App\Contexts\Plans\Application\Commands\Plan\ArchivePlanCommandInterface;

final class ArchivePlanRequest extends BaseCommandRequest
{
    public function toCommand(): ArchivePlanCommandInterface
    {
        return ArchivePlan::of($this->planId);
    }
}
