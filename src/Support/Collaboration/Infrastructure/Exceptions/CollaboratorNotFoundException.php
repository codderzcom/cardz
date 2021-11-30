<?php

namespace Cardz\Support\Collaboration\Infrastructure\Exceptions;

use Cardz\Support\Collaboration\Domain\Exceptions\CollaboratorNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class CollaboratorNotFoundException extends NotFoundException implements CollaboratorNotFoundExceptionInterface
{

}
