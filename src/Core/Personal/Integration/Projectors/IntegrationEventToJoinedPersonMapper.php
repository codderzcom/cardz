<?php

namespace Cardz\Core\Personal\Integration\Projectors;

use Carbon\Carbon;
use Cardz\Core\Personal\Domain\ReadModel\JoinedPerson;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventPayloadProviderTrait;

class IntegrationEventToJoinedPersonMapper
{
    use IntegrationEventPayloadProviderTrait;

    public function map(string $event): ?JoinedPerson
    {
        $payload = $this->getPayloadOrNull($event);
        if ($payload === null) {
            return null;
        }
        return new JoinedPerson(
            $payload->personId,
            $payload->name,
            new Carbon($payload->joined),
        );
    }

}
