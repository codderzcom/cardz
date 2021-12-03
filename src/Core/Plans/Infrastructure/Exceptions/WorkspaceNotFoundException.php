<?php

namespace Cardz\Core\Plans\Infrastructure\Exceptions;

use Cardz\Core\Plans\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class WorkspaceNotFoundException extends NotFoundException implements WorkspaceNotFoundExceptionInterface
{

}
