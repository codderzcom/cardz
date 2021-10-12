<?php

namespace App\Contexts\Plans\Application\Commands\Requirement;

interface ChangeRequirementCommandInterface extends RequirementCommandInterface
{
    public function getDescription(): string;
}
