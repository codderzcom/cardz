<?php

namespace App\Contexts\Auth\Application\Commands;

use App\Contexts\Auth\Domain\Model\User\Password;
use App\Contexts\Auth\Domain\Model\User\Profile;
use App\Contexts\Auth\Domain\Model\User\UserId;
use App\Contexts\Auth\Domain\Model\User\UserIdentity;
use App\Shared\Contracts\Commands\CommandInterface;

interface RegisterUserCommandInterface extends CommandInterface
{
    public function getUserId(): UserId;

    public function getUserIdentity(): UserIdentity;

    public function getProfile(): Profile;

    public function getPassword(): Password;
}
