<?php

namespace Cardz\Core\Cards\Presentation\Controllers\Http\Card\Commands;

use Cardz\Core\Cards\Application\Commands\UnblockCard;

final class UnblockCardRequest extends BaseCommandRequest
{
    public function toCommand(): UnblockCard
    {
        return UnblockCard::of($this->cardId);
    }
}
