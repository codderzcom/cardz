<?php

namespace Cardz\Generic\Identity\Application\Consumers;

use App\Models\User as EloquentUser;
use Cardz\Generic\Identity\Domain\Events\User\RegistrationInitiated;
use Cardz\Generic\Identity\Domain\Model\User\User;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
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
