<?php

namespace App\Contexts\Identity\Application\Consumers;

use App\Contexts\Identity\Domain\Events\User\RegistrationInitiated;
use App\Contexts\Identity\Domain\Model\User\User;
use App\Models\User as EloquentUser;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
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
