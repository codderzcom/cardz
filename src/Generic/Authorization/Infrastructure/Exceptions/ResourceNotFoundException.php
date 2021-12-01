<?php

namespace Cardz\Generic\Authorization\Infrastructure\Exceptions;

use Cardz\Generic\Authorization\Domain\Exceptions\ResourceNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class ResourceNotFoundException extends NotFoundException implements ResourceNotFoundExceptionInterface
{

}
