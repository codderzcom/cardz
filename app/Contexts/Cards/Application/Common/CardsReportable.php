<?php

namespace App\Contexts\Cards\Application\Common;

interface CardsReportable
{
    public function toJSON(): string;
    public function __toString(): string;

    public function getInstanceId(): ?string;
    public function getInstanceOf(): ?string;
}
