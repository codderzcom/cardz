<?php

namespace App\Contexts\Auth\Domain\Model\User;

use App\Contexts\Auth\Domain\Events\User\ProfileProvided;
use App\Contexts\Auth\Domain\Events\User\RegistrationInitiated;
use App\Contexts\Auth\Domain\Model\Shared\AggregateRoot;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class User extends AggregateRoot
{
    private ?Carbon $registrationInitiated = null;

    private ?Profile $profile = null;

    private function __construct(
        public UserIdentity $identity,
    ) {
    }

    #[Pure]
    public static function make(UserIdentity $identity): self
    {
        return new self($identity);
    }

    public function initiateRegistration(): RegistrationInitiated
    {
        $this->registrationInitiated = Carbon::now();
        return RegistrationInitiated::with($this->getId());
    }

    public function provideProfile(Profile $profile): ProfileProvided
    {
        $this->profile = $profile;
        return ProfileProvided::with($this->getId());
    }

    public function isRegistrationInitiated(): bool
    {
        return $this->registrationInitiated !== null;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function getId(): UserId
    {
        return $this->identity->userId;
    }

    #[Pure]
    public function toArray(): array
    {
        return [
            'userId' => (string) $this->identity,
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
        ?Carbon $registrationInitiated,
    ):void {
        $this->identity = UserIdentity::of(UserId::of($userId), $email, $phone);
        $this->profile = Profile::of($name);
        $this->registrationInitiated = $registrationInitiated;
    }
}
