<?php

namespace App\Contexts\Cards\Domain\Events\Card;

use App\Contexts\Cards\Domain\Model\Card\RequirementId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class RequirementsAccepted extends BaseCardDomainEvent
{
}
