<?php

namespace App\Contexts\Collaboration\Infrastructure\Exceptions;

use App\Contexts\Collaboration\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class KeeperNotFoundException extends NotFoundException implements KeeperNotFoundExceptionInterface
{

}
