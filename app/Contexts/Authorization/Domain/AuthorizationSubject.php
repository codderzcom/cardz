<?php

namespace App\Contexts\Authorization\Domain;

use App\Shared\Infrastructure\Authorization\Abac\Attributes;

final class AuthorizationSubject
{
    private function __construct(
        private string $subjectId,
        private Attributes $attributes,
    ) {
        $this->attributes['id'] = $this->subjectId;
    }

    public static function of(string $subjectId, Attributes $attributes): self
    {
        return new self($subjectId, $attributes);
    }

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }
}
