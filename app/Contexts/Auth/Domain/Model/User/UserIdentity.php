<?php

namespace App\Contexts\Auth\Domain\Model\User;

use App\Shared\Contracts\Domain\ValueObjectInterface;
use App\Shared\Exceptions\ParameterAssertionException;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class UserIdentity implements ValueObjectInterface
{
    use ArrayPresenterTrait;

    private const STUB = 'stub';

    private function __construct(
        private ?string $email,
        private ?string $phone,
    ) {
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

    public function __toString()
    {
        return $this->getEmail() ?? $this->getPhone() ?? throw new ParameterAssertionException();
    }
}
