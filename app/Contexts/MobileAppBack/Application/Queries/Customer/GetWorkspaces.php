<?php

namespace App\Contexts\MobileAppBack\Application\Queries\Customer;

use App\Shared\Contracts\Queries\QueryInterface;

final class GetWorkspaces implements QueryInterface
{
    public static function of(): self
    {
        return new self;
    }
}
