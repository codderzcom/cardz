<?php

namespace Cardz\Core\Personal\Domain\ReadModel;

use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;

final class JoinedPerson
{
    use ArrayPresenterTrait;

    public function __construct(
        public string $personId,
        public string $name,
        public Carbon $joined,
    ) {
    }
}
