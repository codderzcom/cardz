<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Requirement\Commands;

use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirement;

final class RemoveRequirementRequest extends BaseCommandRequest
{
    public function toCommand(): RemoveRequirement
    {
        return RemoveRequirement::of($this->requirementId);
    }
}
