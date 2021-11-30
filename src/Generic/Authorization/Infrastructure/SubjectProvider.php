<?php

namespace Cardz\Generic\Authorization\Infrastructure;

use App\Models\User;
use Cardz\Generic\Authorization\Domain\AuthorizationSubject;
use Codderz\Platypus\Exceptions\AuthorizationFailedException;
use Codderz\Platypus\Infrastructure\Authorization\Abac\Attributes;

class SubjectProvider
{
    public function reconstruct(string $subjectId): AuthorizationSubject
    {
        $attributes = $this->getAttributes($subjectId);
        return AuthorizationSubject::of($subjectId, $attributes);
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
