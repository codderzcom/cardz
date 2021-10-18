<?php

namespace App\Contexts\Collaboration\Infrastructure\Exceptions;

use App\Contexts\Collaboration\Domain\Exceptions\RelationNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class RelationNotFoundException extends NotFoundException implements RelationNotFoundExceptionInterface
{

}
