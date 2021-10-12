<?php

namespace App\Contexts\Cards\Application\Services;

use App\Contexts\Cards\Application\Commands\BlockCardCommandInterface;
use App\Contexts\Cards\Application\Commands\CardCommandInterface;
use App\Contexts\Cards\Application\Commands\CompleteCardCommandInterface;
use App\Contexts\Cards\Application\Commands\DismissAchievementCommandInterface;
use App\Contexts\Cards\Application\Commands\FixAchievementDescriptionCommandInterface;
use App\Contexts\Cards\Application\Commands\IssueCardCommandInterface;
use App\Contexts\Cards\Application\Commands\NoteAchievementCommandInterface;
use App\Contexts\Cards\Application\Commands\RevokeCardCommandInterface;
use App\Contexts\Cards\Application\Commands\UnblockCardCommandInterface;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Domain\Model\Plan\Plan;
use App\Contexts\Cards\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Cards\Infrastructure\Persistence\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Shared\Infrastructure\CommandHandling\CommandHandlerFactoryTrait;

class CardAppService
{
    use CommandHandlerFactoryTrait;

    public function __construct(
        private CardRepositoryInterface $cardRepository,
        private PlanRepositoryInterface $planRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function issue(IssueCardCommandInterface $command): CardId
    {
        return $this->release($this
            ->plan($command)
            ->issueCard($command->getCardId(), $command->getCustomerId())
        );
    }

    public function complete(CompleteCardCommandInterface $command): CardId
    {
        return $this->release($this
            ->card($command)
            ->complete()
        );
    }

    public function revoke(RevokeCardCommandInterface $command): CardId
    {
        return $this->release($this
            ->card($command)
            ->revoke()
        );
    }

    public function block(BlockCardCommandInterface $command): CardId
    {
        return $this->release($this
            ->card($command)
            ->block()
        );
    }

    public function unblock(UnblockCardCommandInterface $command): CardId
    {
        return $this->release($this
            ->card($command)
            ->unblock()
        );
    }

    public function noteAchievement(NoteAchievementCommandInterface $command): CardId
    {
        return $this->release($this
            ->card($command)
            ->noteAchievement($command->getAchievement())
        );
    }

    public function dismissAchievement(DismissAchievementCommandInterface $command): CardId
    {
        return $this->release($this
            ->card($command)
            ->dismissAchievement($command->getAchievementId())
        );
    }

    public function fixAchievementDescription(FixAchievementDescriptionCommandInterface $command): CardId
    {
        return $this->release($this
            ->card($command)
            ->fixAchievementDescription($command->getAchievement())
        );
    }

    private function release(Card $card): CardId
    {
        $this->cardRepository->persist($card);
        $this->domainEventBus->publish(...$card->releaseEvents());
        return $card->cardId;
    }

    private function card(CardCommandInterface $command): Card
    {
        return $this->cardRepository->take($command->getCardId());
    }

    private function plan(IssueCardCommandInterface $command): Plan
    {
        return $this->planRepository->take($command->getPlanId());
    }
}
