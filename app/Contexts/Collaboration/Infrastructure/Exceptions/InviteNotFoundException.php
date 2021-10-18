<?php

namespace App\Contexts\Collaboration\Infrastructure\Exceptions;

use App\Contexts\Collaboration\Domain\Exceptions\InviteNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class InviteNotFoundException extends NotFoundException implements InviteNotFoundExceptionInterface
{

}
