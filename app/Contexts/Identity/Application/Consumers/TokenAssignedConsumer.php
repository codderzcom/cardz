<?php

namespace App\Contexts\Identity\Application\Consumers;

use App\Contexts\Identity\Domain\Events\Token\TokenAssigned;
use App\Contexts\Identity\Domain\Model\Token\Token;
use App\Contexts\Identity\Integration\Events\TokenIssued;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;

class TokenAssignedConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
    ) {
    }

    public function consumes(): array
    {
        return [
            TokenAssigned::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var Token $token */
        $token = $event->with();
        $this->integrationEventBus->publish(TokenIssued::of($token));

        /** @var Model $tokenModel */
        $tokenModel = Sanctum::$personalAccessTokenModel;
        $eloquentToken = $tokenModel::query()->where('tokenable_id', '=', $token->userId)->latest()->first();
        if ($eloquentToken === null) {
            return;
        }
        $tokenModel::query()
            ->where('tokenable_id', '=', $token->userId)
            ->where('name', '=', $eloquentToken->name)
            ->whereNotIn('id', [$eloquentToken->id])
            ->delete();
    }
}
