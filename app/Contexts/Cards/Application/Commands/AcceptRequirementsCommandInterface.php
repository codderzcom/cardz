<?php

namespace App\Contexts\Cards\Application\Commands;

use App\Contexts\Cards\Domain\Model\Card\Achievements;

interface AcceptRequirementsCommandInterface extends CardCommandInterface
{
    public function getRequirements(): Achievements;
}
