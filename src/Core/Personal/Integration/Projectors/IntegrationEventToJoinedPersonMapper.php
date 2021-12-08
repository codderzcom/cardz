<?php

namespace Cardz\Core\Personal\Integration\Projectors;

use Carbon\Carbon;
use Cardz\Core\Personal\Domain\ReadModel\JoinedPerson;

class IntegrationEventToJoinedPersonMapper
{
    public function map(string $event): ?JoinedPerson
    {
        $payload = json_decode($event)?->payload;
        if (!is_object($payload)) {
            return null;
        }
        return new JoinedPerson(
            $payload->personId,
            $payload->name,
            new Carbon($payload->joined),
        );
    }

}
