<?php

namespace App\Contexts\Authorization\Policies;

use App\Contexts\Authorization\Domain\AuthorizationObject;
use App\Contexts\Authorization\Domain\AuthorizationSubject;
use App\Shared\Contracts\Authorization\AuthorizationResolution;

class Authorizer
{
    public function resolve(string $action, AuthorizationObject $object, AuthorizationSubject $subject): AuthorizationResolution
    {
        return AuthorizationResolution::of(true);
    }
}
