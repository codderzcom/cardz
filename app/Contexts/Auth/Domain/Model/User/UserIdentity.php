<?php

namespace App\Contexts\Auth\Domain\Model\User;

use App\Contexts\Auth\Domain\Model\Shared\ValueObject;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class UserIdentity extends ValueObject
{
    private const STUB = 'stub';

    private function __construct(
        public UserId $userId,
        private string $email,
        private string $phone,
    ) {
    }

    public static function ofEmail(string $email): self
    {
        return new self(UserId::make(), $email, self::STUB);
    }

    public static function ofPhone(string $phone): self
    {
        return new self(UserId::make(), self::STUB, $phone);
    }

    #[Pure]
    public static function of(UserId $userId, string $email, string $phone): self
    {
        return new self($userId, $email, $phone);
    }

    public function __toString(): string
    {
        return (string) $this->userId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function equals(self $identity): bool
    {
        if ($this->email !== self::STUB) {
            return mb_strtolower($this->email) === mb_strtolower($identity->email);
        }

        if ($this->phone !== self::STUB) {
            return mb_strtolower($this->phone) === mb_strtolower($identity->phone);
        }

        return false;
    }
}
