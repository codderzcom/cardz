<?php

namespace Cardz\Support\Collaboration\Infrastructure\Exceptions;

use Cardz\Support\Collaboration\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class KeeperNotFoundException extends NotFoundException implements KeeperNotFoundExceptionInterface
{

}
