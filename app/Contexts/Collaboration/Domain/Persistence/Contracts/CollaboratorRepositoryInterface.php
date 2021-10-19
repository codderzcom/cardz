<?php

namespace App\Contexts\Collaboration\Domain\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Exceptions\CollaboratorNotFoundExceptionInterface;
use App\Contexts\Collaboration\Domain\Model\Collaborator\Collaborator;

interface CollaboratorRepositoryInterface
{
    /**
     * @throws CollaboratorNotFoundExceptionInterface
     */
    public function take(string $collaboratorId): Collaborator;
}
