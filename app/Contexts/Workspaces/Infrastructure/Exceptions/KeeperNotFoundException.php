<?php

namespace App\Contexts\Workspaces\Infrastructure\Exceptions;

use App\Contexts\Workspaces\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class KeeperNotFoundException extends NotFoundException implements KeeperNotFoundExceptionInterface
{

}
