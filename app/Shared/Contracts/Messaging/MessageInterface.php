<?php

namespace App\Shared\Contracts\Messaging;

use JsonSerializable;
use Stringable;

interface MessageInterface extends Stringable, JsonSerializable
{
}
