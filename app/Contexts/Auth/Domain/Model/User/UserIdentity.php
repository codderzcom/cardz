<?php

namespace App\Contexts\Auth\Domain\Model\User;

use App\Contexts\Auth\Domain\Model\Shared\ValueObject;
use App\Shared\Exceptions\ParameterAssertionException;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class UserIdentity extends ValueObject
{
    private const STUB = 'stub';

    private function __construct(
        private ?string $email,
        private ?string $phone,
    ) {
    }

    public static function ofEmail(string $email): self
    {
        return self::of($email, self::STUB);
    }

    public static function ofPhone(string $phone): self
    {
        return self::of(self::STUB, $phone);
    }

    public static function of(?string $email, ?string $phone): self
    {
        if ($email === null && $phone === null) {
            throw new ParameterAssertionException();
        }
        return new self(
            $email === null ? null : mb_strtolower($email),
            $phone === null ? null : mb_strtolower($phone)
        );
    }

    public function getEmail(): ?string
    {
        return $this->email === self::STUB ? null : $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone === self::STUB ? null : $this->phone;
    }

    public function equals(self $identity): bool
    {
        return $this->email === $identity->email && $this->phone === $identity->phone;
    }
}
