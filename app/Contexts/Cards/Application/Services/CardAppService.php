<?php

namespace App\Contexts\Cards\Application\Services;

use App\Contexts\Cards\Application\Commands\AcceptRequirements;
use App\Contexts\Cards\Application\Commands\BlockCard;
use App\Contexts\Cards\Application\Commands\CardCommandInterface;
use App\Contexts\Cards\Application\Commands\CompleteCard;
use App\Contexts\Cards\Application\Commands\DismissAchievement;
use App\Contexts\Cards\Application\Commands\FixAchievementDescription;
use App\Contexts\Cards\Application\Commands\IssueCard;
use App\Contexts\Cards\Application\Commands\NoteAchievement;
use App\Contexts\Cards\Application\Commands\RevokeCard;
use App\Contexts\Cards\Application\Commands\UnblockCard;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Cards\Infrastructure\Messaging\DomainEventBusInterface;

class CardAppService
{
    public function __construct(
        private CardRepositoryInterface $cardRepository,
        private PlanRepositoryInterface $planRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function issue(IssueCard $command): CardId
    {
        $plan = $this->planRepository->take($command->getPlanId());
        return $this->release($plan->issueCard($command->getCardId(), $command->getCustomerId()));
    }

    public function complete(CompleteCard $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->complete());
    }

    public function revoke(RevokeCard $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->revoke());
    }

    public function block(BlockCard $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->block());
    }

    public function unblock(UnblockCard $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->unblock());
    }

    public function noteAchievement(NoteAchievement $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->noteAchievement($command->getAchievement()));
    }

    public function dismissAchievement(DismissAchievement $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->dismissAchievement($command->getAchievementId()));
    }

    public function fixAchievementDescription(FixAchievementDescription $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->fixAchievementDescription($command->getAchievement()));
    }

    public function acceptRequirements(AcceptRequirements $command): CardId
    {
        $card = $this->card($command);
        return $this->release($card->acceptRequirements($command->getRequirements()));
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
}
