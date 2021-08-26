<?php

namespace App\Contexts\Shared\Contracts;

interface Reportable
{
    public function toJSON(): string;
    public function __toString(): string;

    public function getInstanceId(): ?string;
    public function getInstanceOf(): ?string;
}
