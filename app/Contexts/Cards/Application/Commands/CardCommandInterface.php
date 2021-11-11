<?php

namespace App\Contexts\Cards\Application\Commands;

use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Shared\Contracts\Commands\CommandInterface;

interface CardCommandInterface extends CommandInterface
{
    public function getCardId(): CardId;
}
