<?php

namespace Cardz\Core\Cards\Application\Commands;

use Cardz\Core\Cards\Domain\Model\Card\Achievements;
use Cardz\Core\Cards\Domain\Model\Card\CardId;
use Cardz\Core\Cards\Domain\Model\Plan\Requirement;
use JetBrains\PhpStorm\Pure;

final class AcceptRequirements implements CardCommandInterface
{
    /**
     * @var Requirement[]
     */
    private array $requirements;

    private function __construct(
        private string $cardId,
        Requirement ...$requirements
    ) {
        $this->requirements = $requirements;
    }

    #[Pure]
    public static function of(string $cardId, Requirement ...$requirements): self
    {
        return new self($cardId, ...$requirements);
    }

    public function getCardId(): CardId
    {
        return CardId::of($this->cardId);
    }

    #[Pure]
    public function getRequirements(): Achievements
    {
        return Achievements::from(...$this->requirements);
    }

}
