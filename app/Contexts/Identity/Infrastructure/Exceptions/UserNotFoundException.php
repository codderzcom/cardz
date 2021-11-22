<?php

namespace App\Contexts\Identity\Infrastructure\Exceptions;

use App\Contexts\Identity\Domain\Exceptions\UserNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class UserNotFoundException extends NotFoundException implements UserNotFoundExceptionInterface
{

}
