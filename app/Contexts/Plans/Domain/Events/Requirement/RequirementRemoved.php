<?php

namespace App\Contexts\Plans\Domain\Events\Requirement;

use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class RequirementRemoved extends BaseRequirementDomainEvent
{
}
