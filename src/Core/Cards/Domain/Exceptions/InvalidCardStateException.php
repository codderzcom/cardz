<?php

namespace Cardz\Core\Cards\Domain\Exceptions;

use Codderz\Platypus\Contracts\Exceptions\DomainExceptionInterface;
use RuntimeException;

class InvalidCardStateException extends RuntimeException implements DomainExceptionInterface
{

}
