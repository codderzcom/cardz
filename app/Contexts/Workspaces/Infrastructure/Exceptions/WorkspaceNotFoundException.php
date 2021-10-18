<?php

namespace App\Contexts\Workspaces\Infrastructure\Exceptions;

use App\Contexts\Workspaces\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class WorkspaceNotFoundException extends NotFoundException implements WorkspaceNotFoundExceptionInterface
{

}
