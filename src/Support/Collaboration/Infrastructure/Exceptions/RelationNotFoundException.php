<?php

namespace Cardz\Support\Collaboration\Infrastructure\Exceptions;

use Cardz\Support\Collaboration\Domain\Exceptions\RelationNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class RelationNotFoundException extends NotFoundException implements RelationNotFoundExceptionInterface
{

}
