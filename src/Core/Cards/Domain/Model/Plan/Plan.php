<?php

namespace Cardz\Core\Cards\Domain\Model\Plan;

use Cardz\Core\Cards\Domain\Model\Card\Achievements;
use Cardz\Core\Cards\Domain\Model\Card\Card;
use Cardz\Core\Cards\Domain\Model\Card\CardId;
use Cardz\Core\Cards\Domain\Model\Card\CustomerId;
use Cardz\Core\Cards\Domain\Model\Card\Description;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateRootTrait;
use JetBrains\PhpStorm\Pure;

final class Plan implements AggregateRootInterface
{
    use AggregateRootTrait;

    /**
     * @var Requirement[]
     */
    private array $requirements;

    #[Pure]
    private function __construct(
        private PlanId $planId,
        private string $description,
        Requirement ...$requirements
    ) {
        $this->requirements = $requirements;
    }

    public static function restore(string $planId, string $description, Requirement ...$requirements): self
    {
        return new self(PlanId::of($planId), $description, ...$requirements);
    }

    public function issueCard(CardId $cardId, CustomerId $customerId): Card
    {
        $card = Card::issue($cardId, $this->planId, $customerId, Description::of($this->description));
        $card->acceptRequirements(Achievements::from(...$this->requirements));
        return $card;
    }
}
