<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\RevokeCard;
use App\Contexts\Cards\Application\Commands\RevokeCardCommandInterface;

final class RevokeCardRequest extends BaseCommandRequest
{
    public function toCommand(): RevokeCardCommandInterface
    {
        return RevokeCard::of($this->cardId);
    }
}
