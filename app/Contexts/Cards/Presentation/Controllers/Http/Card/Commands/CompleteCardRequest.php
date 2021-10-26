<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\CompleteCard;

final class CompleteCardRequest extends BaseCommandRequest
{
    public function toCommand(): CompleteCard
    {
        return CompleteCard::of($this->cardId);
    }
}
