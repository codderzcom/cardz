<?php

namespace Cardz\Core\Plans\Presentation\Controllers\Http\Requirement\Commands;

use Cardz\Core\Plans\Application\Commands\Requirement\RemoveRequirement;

final class RemoveRequirementRequest extends BaseCommandRequest
{
    public function toCommand(): RemoveRequirement
    {
        return RemoveRequirement::of($this->requirementId);
    }
}
