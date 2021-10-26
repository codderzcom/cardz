<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\UnblockCard;

final class UnblockCardRequest extends BaseCommandRequest
{
    public function toCommand(): UnblockCard
    {
        return UnblockCard::of($this->cardId);
    }
}
