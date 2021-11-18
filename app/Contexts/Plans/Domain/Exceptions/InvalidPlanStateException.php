<?php

namespace App\Contexts\Plans\Domain\Exceptions;

use App\Shared\Contracts\Exceptions\DomainExceptionInterface;
use Exception;

class InvalidPlanStateException extends Exception implements DomainExceptionInterface
{

}
