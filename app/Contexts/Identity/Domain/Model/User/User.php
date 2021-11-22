<?php

namespace App\Contexts\Identity\Domain\Model\User;

use App\Contexts\Identity\Domain\Events\User\ProfileProvided;
use App\Contexts\Identity\Domain\Events\User\RegistrationInitiated;
use App\Contexts\Identity\Domain\Model\Token\Token;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class User implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Profile $profile = null;

    private ?Password $password = null;

    private ?string $rememberToken = null;

    private ?Carbon $registrationInitiated = null;

    private ?Carbon $emailVerified = null;

    private function __construct(
        public UserId $userId,
        public UserIdentity $identity,
    ) {
    }

    public static function restore(
        string $userId,
        ?string $email,
        ?string $phone,
        string $name,
        string $passwordHash,
        ?string $rememberToken,
        ?Carbon $registrationInitiated,
        ?Carbon $emailVerified,
    ): self {
        $user = new self(UserId::of($userId), UserIdentity::of($email, $phone));
        $user->profile = Profile::of($name);
        $user->password = Password::ofHash($passwordHash);
        $user->rememberToken = $rememberToken;
        $user->registrationInitiated = $registrationInitiated;
        $user->emailVerified = $emailVerified;
        return $user;
    }

    public static function register(UserId $userId, UserIdentity $identity, Password $password, Profile $profile): self
    {
        $user = new self($userId, $identity);
        $user->password = $password;
        $user->registrationInitiated = Carbon::now();
        $user->profile = $profile;
        return $user->withEvents(RegistrationInitiated::of($user), ProfileProvided::of($user));
    }

    public function assignToken(string $plainTextToken): Token
    {
        return Token::assign((string) $this->userId, $plainTextToken);
    }

    public function getPasswordHash(): string
    {
        return (string) $this->password;
    }

    #[Pure]
    public function toArray(): array
    {
        return [
            'userId' => (string) $this->userId,
            'email' => $this->identity->getEmail(),
            'phone' => $this->identity->getPhone(),
            'name' => (string) $this->profile,
        ];
    }
}
