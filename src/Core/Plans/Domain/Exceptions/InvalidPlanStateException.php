<?php

namespace Cardz\Core\Plans\Domain\Exceptions;

use Codderz\Platypus\Contracts\Exceptions\DomainExceptionInterface;
use Exception;

class InvalidPlanStateException extends Exception implements DomainExceptionInterface
{

}
