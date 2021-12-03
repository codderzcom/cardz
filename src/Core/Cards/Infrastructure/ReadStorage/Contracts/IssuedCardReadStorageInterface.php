<?php

namespace Cardz\Core\Cards\Infrastructure\ReadStorage\Contracts;

use Cardz\Core\Cards\Domain\ReadModel\IssuedCard;

interface IssuedCardReadStorageInterface
{
    public function find(string $cardId): ?IssuedCard;

    /**
     * @param string $planId
     * @return IssuedCard[]
     */
    public function allForPlanId(string $planId): array;
}
