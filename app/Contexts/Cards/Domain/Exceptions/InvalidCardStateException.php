<?php

namespace App\Contexts\Cards\Domain\Exceptions;

use App\Shared\Contracts\Exceptions\DomainExceptionInterface;
use Exception;

class InvalidCardStateException extends Exception implements DomainExceptionInterface
{

}
