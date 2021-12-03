<?php

namespace Cardz\Core\Plans\Infrastructure\Exceptions;

use Cardz\Core\Plans\Domain\Exceptions\RequirementNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class RequirementNotFoundException extends NotFoundException implements RequirementNotFoundExceptionInterface
{

}
