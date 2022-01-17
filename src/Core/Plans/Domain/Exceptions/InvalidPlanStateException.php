<?php

namespace Cardz\Core\Plans\Domain\Exceptions;

use Codderz\Platypus\Contracts\Exceptions\DomainExceptionInterface;
use RuntimeException;

class InvalidPlanStateException extends RuntimeException implements DomainExceptionInterface
{

}
