<?php

namespace Cardz\Generic\Identity\Application\Services;

use Cardz\Generic\Identity\Application\Commands\RegisterUser;
use Cardz\Generic\Identity\Application\Exceptions\UserExistsException;
use Cardz\Generic\Identity\Domain\Model\User\User;
use Cardz\Generic\Identity\Domain\Model\User\UserId;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Infrastructure\Messaging\DomainEventBusInterface;

class UserAppService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function register(RegisterUser $command): UserId
    {
        if ($this->userRepository->isExistingIdentity($command->getUserIdentity())) {
            throw new UserExistsException("User with given identity already registered");
        }

        $user = User::register($command->getUserId(), $command->getUserIdentity(), $command->getPassword(), $command->getProfile());
        $this->userRepository->persist($user);
        $this->domainEventBus->publish(...$user->releaseEvents());
        return $user->userId;
    }

}
