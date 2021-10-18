<?php

namespace App\Contexts\Auth\Infrastructure\Exceptions;

use App\Contexts\Auth\Domain\Exceptions\UserNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class UserNotFoundException extends NotFoundException implements UserNotFoundExceptionInterface
{

}
