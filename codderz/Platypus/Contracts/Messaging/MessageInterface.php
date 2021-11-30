<?php

namespace Codderz\Platypus\Contracts\Messaging;

use JsonSerializable;
use Stringable;

interface MessageInterface extends Stringable, JsonSerializable
{
}
