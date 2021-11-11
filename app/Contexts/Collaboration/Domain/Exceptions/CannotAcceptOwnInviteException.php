<?php

namespace App\Contexts\Collaboration\Domain\Exceptions;

use App\Shared\Contracts\Exceptions\DomainExceptionInterface;
use Exception;

class CannotAcceptOwnInviteException extends Exception implements DomainExceptionInterface
{

}
