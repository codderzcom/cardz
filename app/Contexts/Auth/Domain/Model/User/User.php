<?php

namespace App\Contexts\Auth\Domain\Model\User;

use App\Contexts\Auth\Domain\Events\User\ProfileProvided;
use App\Contexts\Auth\Domain\Events\User\RegistrationInitiated;
use App\Contexts\Auth\Domain\Model\Shared\AggregateRoot;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class User extends AggregateRoot
{
    private ?Profile $profile = null;

    private ?string $password = null;

    private ?string $rememberToken = null;

    private ?Carbon $registrationInitiated = null;

    private ?Carbon $emailVerified = null;

    private function __construct(
        public UserId $userId,
        public UserIdentity $identity,
    ) {
    }

    #[Pure]
    public static function make(UserId $userId, UserIdentity $identity): self
    {
        return new self($userId, $identity);
    }

    public function initiateRegistration(string $password): RegistrationInitiated
    {
        $this->registrationInitiated = Carbon::now();
        $this->password = $password;
        return RegistrationInitiated::with($this->userId);
    }

    public function provideProfile(Profile $profile): ProfileProvided
    {
        $this->profile = $profile;
        return ProfileProvided::with($this->userId);
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function isRegistrationInitiated(): bool
    {
        return $this->registrationInitiated !== null;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerified !== null;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    #[Pure]
    public function toArray(): array
    {
        return [
            'userId' => (string) $this->userId,
            'identity' => (string) $this->identity,
            'email' => $this->identity->getEmail(),
            'phone' => $this->identity->getPhone(),
            'name' => $this->profile->getName(),
        ];
    }

    private function from(
        string $userId,
        ?string $email,
        ?string $phone,
        ?string $name,
        ?string $password,
        ?string $rememberToken,
        ?Carbon $registrationInitiated,
        ?Carbon $emailVerified,
    ): void {
        $this->userId = UserId::of($userId);
        $this->identity = UserIdentity::of($email, $phone);
        $this->profile = Profile::of($name);
        $this->password = $password;
        $this->rememberToken = $rememberToken;
        $this->registrationInitiated = $registrationInitiated;
        $this->emailVerified = $emailVerified;
    }
}
