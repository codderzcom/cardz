<?php

namespace App\Shared\Exceptions;

use App\Shared\Contracts\Exceptions\NotFoundExceptionInterface;
use Exception;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{

}
