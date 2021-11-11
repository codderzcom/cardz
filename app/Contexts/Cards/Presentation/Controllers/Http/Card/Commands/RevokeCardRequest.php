<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\RevokeCard;

final class RevokeCardRequest extends BaseCommandRequest
{
    public function toCommand(): RevokeCard
    {
        return RevokeCard::of($this->cardId);
    }
}
