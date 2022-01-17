<?php

namespace Cardz\Support\Collaboration\Domain\Exceptions;

use Codderz\Platypus\Contracts\Exceptions\DomainExceptionInterface;
use RuntimeException;

class CannotAcceptOwnInviteException extends RuntimeException implements DomainExceptionInterface
{

}
