<?php

namespace App\Contexts\Cards\Application\Services;

use App\Contexts\Cards\Application\Commands\AcceptRequirementsCommandInterface;
use App\Contexts\Cards\Application\Commands\BlockCardCommandInterface;
use App\Contexts\Cards\Application\Commands\CompleteCardCommandInterface;
use App\Contexts\Cards\Application\Commands\DismissAchievementCommandInterface;
use App\Contexts\Cards\Application\Commands\FixAchievementDescriptionCommandInterface;
use App\Contexts\Cards\Application\Commands\IssueCardCommandInterface;
use App\Contexts\Cards\Application\Commands\NoteAchievementCommandInterface;
use App\Contexts\Cards\Application\Commands\RevokeCardCommandInterface;
use App\Contexts\Cards\Application\Commands\UnblockCardCommandInterface;
use App\Contexts\Cards\Application\Exceptions\CardNotFoundException;
use App\Contexts\Cards\Application\Exceptions\PlanNotFoundException;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Cards\Infrastructure\Persistence\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Infrastructure\CommandHandling\CommandHandlerFactoryTrait;

class CardAppService
{
    use CommandHandlerFactoryTrait;

    public function __construct(
        private CardRepositoryInterface $cardRepository,
        private PlanRepositoryInterface $planRepository,
        private DomainEventBusInterface $domainEventBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function registerHandlers(): void
    {
        $this->commandBus->registerHandlers(
            $this->makeHandlerFor(AcceptRequirementsCommandInterface::class, 'acceptRequirements'),
            $this->makeHandlerFor(BlockCardCommandInterface::class, 'block'),
            $this->makeHandlerFor(CompleteCardCommandInterface::class, 'complete'),
            $this->makeHandlerFor(DismissAchievementCommandInterface::class, 'dismissAchievement'),
            $this->makeHandlerFor(FixAchievementDescriptionCommandInterface::class, 'fixAchievementDescription'),
            $this->makeHandlerFor(IssueCardCommandInterface::class, 'issue'),
            $this->makeHandlerFor(NoteAchievementCommandInterface::class, 'noteAchievement'),
            $this->makeHandlerFor(RevokeCardCommandInterface::class, 'revoke'),
            $this->makeHandlerFor(UnblockCardCommandInterface::class, 'unblock'),
        );
    }

    public function issue(IssueCardCommandInterface $command): CardId
    {
        $plan = $this->planRepository->take($command->getPlanId());

        if ($plan === null) {
            throw new PlanNotFoundException();
        }

        $card = $plan->issueCard($command->getCardId(), $command->getCustomerId());
        return $this->releaseCard($card);
    }

    public function complete(CompleteCardCommandInterface $command): CardId
    {
        $card = $this->cardRepository->take($command->getCardId());
        if ($card === null) {
            throw new CardNotFoundException();
        }

        $card->complete();
        return $this->releaseCard($card);
    }

    public function revoke(RevokeCardCommandInterface $command): CardId
    {
        $card = $this->cardRepository->take($command->getCardId());
        if ($card === null) {
            throw new CardNotFoundException();
        }

        $card->revoke();
        return $this->releaseCard($card);
    }

    public function block(BlockCardCommandInterface $command): CardId
    {
        $card = $this->cardRepository->take($command->getCardId());
        if ($card === null) {
            throw new CardNotFoundException();
        }

        $card->block();
        return $this->releaseCard($card);
    }

    public function unblock(UnblockCardCommandInterface $command): CardId
    {
        $card = $this->cardRepository->take($command->getCardId());
        if ($card === null) {
            throw new CardNotFoundException();
        }

        $card->unblock();
        return $this->releaseCard($card);
    }

    public function noteAchievement(NoteAchievementCommandInterface $command): CardId
    {
        $card = $this->cardRepository->take($command->getCardId());
        if ($card === null) {
            throw new CardNotFoundException();
        }

        $card->noteAchievement($command->getAchievement());
        return $this->releaseCard($card);
    }

    public function dismissAchievement(DismissAchievementCommandInterface $command): CardId
    {
        $card = $this->cardRepository->take($command->getCardId());
        if ($card === null) {
            throw new CardNotFoundException();
        }

        $card->dismissAchievement($command->getAchievementId());
        return $this->releaseCard($card);
    }

    /**
     * @throws CardNotFoundException
     */
    public function fixAchievementDescription(FixAchievementDescriptionCommandInterface $command): CardId
    {
        $card = $this->cardRepository->take($command->getCardId());
        if ($card === null) {
            throw new CardNotFoundException();
        }

        $card->fixAchievementDescription($command->getAchievement());
        return $this->releaseCard($card);
    }

    public function acceptRequirements(AcceptRequirementsCommandInterface $command): CardId
    {
        $card = $this->cardRepository->take($command->getCardId());
        if ($card === null) {
            throw new CardNotFoundException();
        }

        $card->acceptRequirements($command->getRequirements());
        return $this->releaseCard($card);
    }

    private function releaseCard(Card $card): CardId
    {
        $this->cardRepository->persist($card);
        $this->domainEventBus->publish(...$card->releaseEvents());
        return $card->cardId;
    }
}
