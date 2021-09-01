<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Shared\Infrastructure\Support\GuidBasedImmutableId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class RequirementId extends GuidBasedImmutableId
{
}
