<?php

namespace App\Contexts\Collaboration\Application\Commands\Relation;

use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Shared\Contracts\Commands\CommandInterface;

interface RelationCommandInterface extends CommandInterface
{
    public function getRelationId(): RelationId;
}
