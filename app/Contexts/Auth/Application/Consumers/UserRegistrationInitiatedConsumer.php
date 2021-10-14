<?php

namespace App\Contexts\Auth\Application\Consumers;

use App\Contexts\Auth\Domain\Events\User\RegistrationInitiated;
use App\Contexts\Auth\Domain\Model\User\User;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Auth;

class UserRegistrationInitiatedConsumer implements EventConsumerInterface
{
    public function consumes(): array
    {
        return [
            RegistrationInitiated::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var User $user */
        $user = $event->with();

        /** @var EloquentUser $eloquentUser */
        $eloquentUser = EloquentUser::query()->find((string) $user->userId);
        if ($eloquentUser === null) {
            return;
        }
        Auth::login($eloquentUser);
    }

}
