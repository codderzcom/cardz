<?php

namespace Cardz\Core\Cards\Infrastructure\Exceptions;

use Cardz\Core\Cards\Domain\Exceptions\PlanNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class PlanNotFoundException extends NotFoundException implements PlanNotFoundExceptionInterface
{

}
