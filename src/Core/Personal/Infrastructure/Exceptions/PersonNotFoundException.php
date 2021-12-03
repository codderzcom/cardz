<?php

namespace Cardz\Core\Personal\Infrastructure\Exceptions;

use Cardz\Core\Personal\Domain\Exception\PersonNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class PersonNotFoundException extends NotFoundException implements PersonNotFoundExceptionInterface
{

}
