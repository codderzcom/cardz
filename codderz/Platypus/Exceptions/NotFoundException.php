<?php

namespace Codderz\Platypus\Exceptions;

use Codderz\Platypus\Contracts\Exceptions\NotFoundExceptionInterface;
use Exception;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{

}
