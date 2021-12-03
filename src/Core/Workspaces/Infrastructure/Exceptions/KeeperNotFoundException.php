<?php

namespace Cardz\Core\Workspaces\Infrastructure\Exceptions;

use Cardz\Core\Workspaces\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class KeeperNotFoundException extends NotFoundException implements KeeperNotFoundExceptionInterface
{

}
