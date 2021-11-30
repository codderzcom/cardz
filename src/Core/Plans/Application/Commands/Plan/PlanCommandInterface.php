<?php

namespace Cardz\Core\Plans\Application\Commands\Plan;

use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

interface PlanCommandInterface extends CommandInterface
{
    public function getPlanId(): PlanId;
}
