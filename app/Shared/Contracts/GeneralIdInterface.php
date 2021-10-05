<?php

namespace App\Shared\Contracts;

use JsonSerializable;

#
interface GeneralIdInterface extends JsonSerializable
{
    public static function make(): static;

    public static function makeValue(): string;

    public static function of(string $id): static;

    public function equals(GeneralIdInterface $id): bool;

    public function jsonSerialize();

    public function __toString(): string;
}
