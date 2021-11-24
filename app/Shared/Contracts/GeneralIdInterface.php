<?php

namespace App\Shared\Contracts;

use JsonSerializable;
use Stringable;

interface GeneralIdInterface extends JsonSerializable, Stringable
{
    public static function make(): static;

    public static function makeValue(): string;

    public static function of(string $id): static;

    public function equals(GeneralIdInterface $id): bool;

    public function is(string $id): bool;

    public function jsonSerialize();

    public function __toString(): string;
}
