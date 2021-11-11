<?php

namespace App\Contexts\Plans\Infrastructure\Exceptions;

use App\Contexts\Plans\Domain\Exceptions\PlanNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class PlanNotFoundException extends NotFoundException implements PlanNotFoundExceptionInterface
{

}
