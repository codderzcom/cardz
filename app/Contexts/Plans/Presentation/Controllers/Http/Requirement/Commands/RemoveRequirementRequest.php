<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Requirement\Commands;

use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirement;
use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirementCommandInterface;

final class RemoveRequirementRequest extends BaseCommandRequest
{
    public function toCommand(): RemoveRequirementCommandInterface
    {
        return RemoveRequirement::of($this->requirementId);
    }
}
