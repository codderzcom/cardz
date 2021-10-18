<?php

namespace App\Shared\Exceptions;

use App\Shared\Contracts\ApplicationExceptionInterface;
use App\Shared\Contracts\NotFoundExceptionInterface;
use Exception;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{

}
