<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\UnblockCard;
use App\Contexts\Cards\Application\Commands\UnblockCardCommandInterface;

final class UnblockCardRequest extends BaseCommandRequest
{
    public function toCommand(): UnblockCardCommandInterface
    {
        return UnblockCard::of($this->cardId);
    }
}
