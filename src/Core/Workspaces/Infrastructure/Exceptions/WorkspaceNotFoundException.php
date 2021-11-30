<?php

namespace Cardz\Core\Workspaces\Infrastructure\Exceptions;

use Cardz\Core\Workspaces\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use Codderz\Platypus\Exceptions\NotFoundException;

class WorkspaceNotFoundException extends NotFoundException implements WorkspaceNotFoundExceptionInterface
{

}
