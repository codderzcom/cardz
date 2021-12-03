<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ACL\Cards;

use Cardz\Core\Cards\Application\Commands\BlockCard;
use Cardz\Core\Cards\Application\Commands\CompleteCard;
use Cardz\Core\Cards\Application\Commands\DismissAchievement;
use Cardz\Core\Cards\Application\Commands\IssueCard;
use Cardz\Core\Cards\Application\Commands\NoteAchievement;
use Cardz\Core\Cards\Application\Commands\RevokeCard;
use Cardz\Core\Cards\Application\Commands\UnblockCard;
use Cardz\Support\MobileAppGateway\Integration\Contracts\CardsContextInterface;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;

class MonolithCardsAdapter implements CardsContextInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function issue(string $planId, string $customerId): string
    {
        $command = IssueCard::of($planId, $customerId);
        $this->commandBus->dispatch($command);
        return $command->getCardId();
    }

    public function complete(string $cardId): string
    {
        $command = CompleteCard::of($cardId);
        $this->commandBus->dispatch($command);
        return $command->getCardId();
    }

    public function revoke(string $cardId): string
    {
        $command = RevokeCard::of($cardId);
        $this->commandBus->dispatch($command);
        return $command->getCardId();
    }

    public function block(string $cardId): string
    {
        $command = BlockCard::of($cardId);
        $this->commandBus->dispatch($command);
        return $command->getCardId();
    }

    public function unblock(string $cardId): string
    {
        $command = UnblockCard::of($cardId);
        $this->commandBus->dispatch($command);
        return $command->getCardId();
    }

    public function noteAchievement(string $cardId, string $achievementId, string $description): string
    {
        $command = NoteAchievement::of($cardId, $achievementId, $description);
        $this->commandBus->dispatch($command);
        return $command->getCardId();
    }

    public function dismissAchievement(string $cardId, string $achievementId): string
    {
        $command = DismissAchievement::of($cardId, $achievementId);
        $this->commandBus->dispatch($command);
        return $command->getCardId();
    }

}
