<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Collaborator\Collaborator;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\CollaboratorRepositoryInterface;

class CollaboratorRepository implements CollaboratorRepositoryInterface
{
    public function take(string $collaboratorId): Collaborator
    {
        return Collaborator::restore($collaboratorId);
    }
}
