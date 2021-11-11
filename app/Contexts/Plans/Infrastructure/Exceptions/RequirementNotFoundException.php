<?php

namespace App\Contexts\Plans\Infrastructure\Exceptions;

use App\Contexts\Plans\Domain\Exceptions\RequirementNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class RequirementNotFoundException extends NotFoundException implements RequirementNotFoundExceptionInterface
{

}
