<?php

namespace App\Shared\Infrastructure\Rpc;

use App\Shared\Contracts\Rpc\RpcRequestIdInterface;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;

class RpcRequestId extends GuidBasedImmutableId implements RpcRequestIdInterface
{

}
