<?php

namespace Cardz\Core\Cards\Domain\Exceptions;

use Codderz\Platypus\Contracts\Exceptions\DomainExceptionInterface;
use Exception;

class InvalidCardStateException extends Exception implements DomainExceptionInterface
{

}
