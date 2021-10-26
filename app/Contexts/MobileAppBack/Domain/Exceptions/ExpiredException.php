<?php

namespace App\Contexts\MobileAppBack\Domain\Exceptions;

use App\Contexts\MobileAppBack\Application\Contracts\DomainExceptionInterface;
use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ExpiredException extends Exception implements DomainExceptionInterface
{
    #[Pure]
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        $message = $message ?: 'Expired';
        parent::__construct($message, $code, $previous);
    }

}
