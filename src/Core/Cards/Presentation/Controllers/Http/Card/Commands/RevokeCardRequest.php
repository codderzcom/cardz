<?php

namespace Cardz\Core\Cards\Presentation\Controllers\Http\Card\Commands;

use Cardz\Core\Cards\Application\Commands\RevokeCard;

final class RevokeCardRequest extends BaseCommandRequest
{
    public function toCommand(): RevokeCard
    {
        return RevokeCard::of($this->cardId);
    }
}
