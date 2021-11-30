<?php

namespace Cardz\Core\Plans\Presentation\Controllers\Http\Plan\Commands;

use Cardz\Core\Plans\Application\Commands\Plan\ArchivePlan;

final class ArchivePlanRequest extends BaseCommandRequest
{
    public function toCommand(): ArchivePlan
    {
        return ArchivePlan::of($this->planId);
    }
}
