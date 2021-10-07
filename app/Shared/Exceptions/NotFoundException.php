<?php

namespace App\Shared\Exceptions;

use App\Shared\Contracts\ApplicationExceptionInterface;
use Exception;

class NotFoundException extends Exception implements ApplicationExceptionInterface
{

}
