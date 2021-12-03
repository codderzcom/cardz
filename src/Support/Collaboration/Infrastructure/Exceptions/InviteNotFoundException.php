<?php

namespace Cardz\Support\Collaboration\Infrastructure\Exceptions;

use Cardz\Support\Collaboration\Domain\Exceptions\InviteNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class InviteNotFoundException extends NotFoundException implements InviteNotFoundExceptionInterface
{

}
