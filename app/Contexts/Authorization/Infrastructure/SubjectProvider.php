<?php

namespace App\Contexts\Authorization\Infrastructure;

use App\Contexts\Authorization\Domain\AuthorizationObject;
use App\Contexts\Authorization\Exceptions\AuthorizationFailedException;
use App\Models\User;
use App\Shared\Infrastructure\Authorization\Abac\Attributes;

class SubjectProvider
{
    public function reconstruct(string $subjectId): AuthorizationObject
    {
        $attributes = $this->getAttributes($subjectId);
        return AuthorizationObject::of($subjectId, $attributes);
    }

    protected function getAttributes(string $subjectId): Attributes
    {
        $subject = User::query()->find($subjectId);
        if ($subject === null) {
            throw new AuthorizationFailedException("Subject not found");
        }
        return Attributes::of([
            'subjectId' => $subject->id,
        ]);
    }
}
