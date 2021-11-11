<?php

namespace App\Contexts\MobileAppBack\Domain\Model\Customer;

use App\Shared\Infrastructure\Support\GuidBasedImmutableId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class CustomerId extends GuidBasedImmutableId
{
}
