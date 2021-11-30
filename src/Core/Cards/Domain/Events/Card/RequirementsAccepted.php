<?php

namespace Cardz\Core\Cards\Domain\Events\Card;

use Cardz\Core\Cards\Domain\Model\Card\RequirementId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class RequirementsAccepted extends BaseCardDomainEvent
{
}
