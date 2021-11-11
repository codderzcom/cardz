<?php

namespace App\Contexts\Cards\Infrastructure\Exceptions;

use App\Contexts\Cards\Domain\Exceptions\PlanNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class PlanNotFoundException extends NotFoundException implements PlanNotFoundExceptionInterface
{

}
