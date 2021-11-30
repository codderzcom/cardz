<?php

namespace Cardz\Core\Cards\Application\Commands;

use Cardz\Core\Cards\Domain\Model\Card\CardId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

interface CardCommandInterface extends CommandInterface
{
    public function getCardId(): CardId;
}
