<?php

namespace App\Contexts\Collaboration\Infrastructure\Exceptions;

use App\Contexts\Collaboration\Domain\Exceptions\CollaboratorNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class CollaboratorNotFoundException extends NotFoundException implements CollaboratorNotFoundExceptionInterface
{

}
