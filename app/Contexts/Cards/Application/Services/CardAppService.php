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
use App\Contexts\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Cards\Infrastructure\Messaging\DomainEventBusInterface;
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
        $plan = $this->plan($command);
        return $this->release($plan->issueCard($command->getCardId(), $command->getCustomerId()));
    }

    public function complete(CompleteCardCommandInterface $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->complete());
    }

    public function revoke(RevokeCardCommandInterface $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->revoke());
    }

    public function block(BlockCardCommandInterface $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->block());
    }

    public function unblock(UnblockCardCommandInterface $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->unblock());
    }

    public function noteAchievement(NoteAchievementCommandInterface $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->noteAchievement($command->getAchievement()));
    }

    public function dismissAchievement(DismissAchievementCommandInterface $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->dismissAchievement($command->getAchievementId()));
    }

    public function fixAchievementDescription(FixAchievementDescriptionCommandInterface $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->fixAchievementDescription($command->getAchievement()));
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
