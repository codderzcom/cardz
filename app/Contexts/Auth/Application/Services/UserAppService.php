<?php

namespace App\Contexts\Auth\Application\Services;

use App\Contexts\Auth\Application\Commands\RegisterUserCommandInterface;
use App\Contexts\Auth\Application\Exceptions\UserExistsException;
use App\Contexts\Auth\Domain\Model\User\User;
use App\Contexts\Auth\Domain\Model\User\UserId;
use App\Contexts\Auth\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Auth\Infrastructure\Messaging\DomainEventBusInterface;

class UserAppService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function register(RegisterUserCommandInterface $command): UserId
    {
        //ToDo: здесь?
        if ($this->userRepository->isExistingIdentity($command->getUserIdentity())) {
            throw new UserExistsException("User already registered");
        }

        $user = User::register(UserId::make(), $command->getUserIdentity(), $command->getPassword(), $command->getProfile());
        $this->userRepository->persist($user);
        $this->domainEventBus->publish(...$user->releaseEvents());
        return $user->userId;
    }

}
