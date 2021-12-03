<?php

namespace Cardz\Core\Cards\Infrastructure\Exceptions;

use Cardz\Core\Cards\Domain\Exceptions\CardNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class CardNotFoundException extends NotFoundException implements CardNotFoundExceptionInterface
{

}
