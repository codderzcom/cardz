<?php

namespace App\Contexts\Collaboration\Domain\Exceptions;

use App\Shared\Contracts\Exceptions\DomainExceptionInterface;
use Exception;

class InvalidOperationException extends Exception implements DomainExceptionInterface
{

}
