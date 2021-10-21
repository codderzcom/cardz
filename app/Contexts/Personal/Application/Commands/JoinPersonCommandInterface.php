<?php

namespace App\Contexts\Personal\Application\Commands;

use App\Contexts\Personal\Domain\Model\Person\Name;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Shared\Contracts\Commands\CommandInterface;

interface JoinPersonCommandInterface extends CommandInterface
{
    public function getPersonId(): PersonId;

    public function getName(): Name;
}
