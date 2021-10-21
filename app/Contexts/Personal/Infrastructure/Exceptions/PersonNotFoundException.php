<?php

namespace App\Contexts\Personal\Infrastructure\Exceptions;

use App\Contexts\Personal\Domain\Exception\PersonNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class PersonNotFoundException extends NotFoundException implements PersonNotFoundExceptionInterface
{

}
