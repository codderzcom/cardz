<?php

namespace App\Contexts\Auth\Application\Exceptions;

use App\Shared\Contracts\ApplicationExceptionInterface;
use Exception;

class UserNotFoundException extends Exception implements ApplicationExceptionInterface
{

}
