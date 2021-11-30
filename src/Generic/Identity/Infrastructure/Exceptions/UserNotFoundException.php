<?php

namespace Cardz\Generic\Identity\Infrastructure\Exceptions;

use Cardz\Generic\Identity\Domain\Exceptions\UserNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class UserNotFoundException extends NotFoundException implements UserNotFoundExceptionInterface
{

}
