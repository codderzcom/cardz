<?php

namespace App\Contexts\MobileAppBack\Domain\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ReconstructionException extends Exception
{
    #[Pure]
    public function __construct(
        $message = "",
        protected array $constructionData = [],
        $code = 0,
        Throwable $previous = null,
    ) {
        $message = $message ?: 'Failed to reconstruct object from given data';
        parent::__construct($message, $code, $previous);
    }

    public function getConstructionData(): array
    {
        return $this->constructionData;
    }
}
