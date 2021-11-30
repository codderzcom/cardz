<?php

namespace Cardz\Core\Plans\Infrastructure\Exceptions;

use Cardz\Core\Plans\Domain\Exceptions\PlanNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class PlanNotFoundException extends NotFoundException implements PlanNotFoundExceptionInterface
{

}
