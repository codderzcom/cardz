<?php

namespace Cardz\Support\Collaboration\Domain\Exceptions;

use Codderz\Platypus\Contracts\Exceptions\DomainExceptionInterface;
use Exception;

class CannotAcceptOwnInviteException extends Exception implements DomainExceptionInterface
{

}
