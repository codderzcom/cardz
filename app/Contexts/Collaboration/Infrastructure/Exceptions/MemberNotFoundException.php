<?php

namespace App\Contexts\Collaboration\Infrastructure\Exceptions;

use App\Contexts\Collaboration\Domain\Exceptions\MemberNotFoundExceptionInterface;
use App\Shared\Exceptions\NotFoundException;

class MemberNotFoundException extends NotFoundException implements MemberNotFoundExceptionInterface
{

}
