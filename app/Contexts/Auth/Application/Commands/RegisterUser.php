<?php

namespace App\Contexts\Auth\Application\Commands;

use App\Contexts\Auth\Domain\Model\User\Password;
use App\Contexts\Auth\Domain\Model\User\Profile;
use App\Contexts\Auth\Domain\Model\User\UserId;
use App\Contexts\Auth\Domain\Model\User\UserIdentity;
use App\Shared\Contracts\Commands\CommandInterface;

final class RegisterUser implements CommandInterface
{
    private function __construct(
        private string $userId,
        private string $name,
        private string $password,
        private ?string $email,
        private ?string $phone,
    ) {
    }

    public static function of(string $name, string $password, ?string $email, ?string $phone): self
    {
        return new self(UserId::makeValue(), $name, $password, $email, $phone);
    }

    public function getUserId(): UserId
    {
        return UserId::of($this->userId);
    }

    public function getUserIdentity(): UserIdentity
    {
        return UserIdentity::of($this->email, $this->phone);
    }

    public function getProfile(): Profile
    {
        return Profile::of($this->name);
    }

    public function getPassword(): Password
    {
        return Password::of($this->password);
    }

}
