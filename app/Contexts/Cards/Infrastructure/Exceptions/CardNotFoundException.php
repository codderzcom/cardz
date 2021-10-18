<?php

namespace App\Contexts\Cards\Infrastructure\Exceptions;

use App\Contexts\Cards\Domain\Exceptions\CardNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class CardNotFoundException extends NotFoundException implements CardNotFoundExceptionInterface
{

}
