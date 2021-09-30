<?php

namespace App\Contexts\Workspaces\Application\Exceptions;

use App\Shared\Contracts\ApplicationExceptionInterface;
use Exception;

class KeeperNotFoundException extends Exception implements ApplicationExceptionInterface
{

}
