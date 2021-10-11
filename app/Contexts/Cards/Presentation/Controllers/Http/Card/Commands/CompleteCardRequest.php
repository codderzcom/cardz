<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\CompleteCard;
use App\Contexts\Cards\Application\Commands\CompleteCardCommandInterface;

final class CompleteCardRequest extends BaseCommandRequest
{
    public function toCommand(): CompleteCardCommandInterface
    {
        return CompleteCard::of($this->cardId);
    }
}
