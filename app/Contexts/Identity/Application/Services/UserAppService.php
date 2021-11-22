<?php

namespace App\Contexts\Identity\Application\Services;

use App\Contexts\Identity\Application\Commands\RegisterUser;
use App\Contexts\Identity\Application\Exceptions\UserExistsException;
use App\Contexts\Identity\Domain\Model\User\User;
use App\Contexts\Identity\Domain\Model\User\UserId;
use App\Contexts\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Identity\Infrastructure\Messaging\DomainEventBusInterface;

class UserAppService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function register(RegisterUser $command): UserId
    {
        //ToDo: здесь?
        if ($this->userRepository->isExistingIdentity($command->getUserIdentity())) {
            throw new UserExistsException("User already registered");
        }

        $user = User::register($command->getUserId(), $command->getUserIdentity(), $command->getPassword(), $command->getProfile());
        $this->userRepository->persist($user);
        $this->domainEventBus->publish(...$user->releaseEvents());
        return $user->userId;
    }

}
