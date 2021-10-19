<?php

namespace App\Contexts\Collaboration\Domain\Exceptions;

use App\Contexts\MobileAppBack\Application\Contracts\DomainExceptionInterface;
use Exception;

class CannotAcceptOwnInviteException extends Exception implements DomainExceptionInterface
{

}
