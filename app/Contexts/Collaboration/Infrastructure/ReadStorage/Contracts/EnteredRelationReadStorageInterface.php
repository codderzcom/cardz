<?php

namespace App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts;

use App\Contexts\Collaboration\Domain\ReadModel\EnteredRelation;

interface EnteredRelationReadStorageInterface
{
    public function take(string $relationId): ?EnteredRelation;
}
