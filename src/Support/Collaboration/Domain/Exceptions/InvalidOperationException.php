<?php

namespace Cardz\Support\Collaboration\Domain\Exceptions;

use Codderz\Platypus\Contracts\Exceptions\DomainExceptionInterface;
use RuntimeException;

class InvalidOperationException extends RuntimeException implements DomainExceptionInterface
{

}
