<?php

namespace App\Contexts\Plans\Infrastructure\Exceptions;

use App\Contexts\Plans\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class WorkspaceNotFoundException extends NotFoundException implements WorkspaceNotFoundExceptionInterface
{

}
