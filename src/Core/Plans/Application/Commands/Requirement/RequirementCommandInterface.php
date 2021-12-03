<?php

namespace Cardz\Core\Plans\Application\Commands\Requirement;

use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

interface RequirementCommandInterface extends CommandInterface
{
    public function getRequirementId(): RequirementId;
}
