<?php

namespace App\Shared\Infrastructure\Authorization\Abac;

use App\Shared\Contracts\Authorization\Abac\AbacAuthorizationRequest;
use App\Shared\Contracts\Authorization\Abac\AbacResolverInterface;
use App\Shared\Contracts\Authorization\AuthorizationResolution;

class AbacEngine
{
    private array $rules = [];
    private AbacResolverInterface $resolver;

    public function setup(AbacResolverInterface $resolver, array $rules): void
    {
        $this->rules = $rules;
        $this->resolver = $resolver;
    }

    public function resolve(AbacAuthorizationRequest $authorizationRequest): AuthorizationResolution
    {
        $subjectAttributes = $authorizationRequest->getSubjectAttributes();
        $objectAttributes = $authorizationRequest->getObjectAttributes();
        $configAttributes = $authorizationRequest->getConfigAttributes();
        $permission = $authorizationRequest->getPermission();
        $rule = $this->getRule($permission);
        $this->resolver->resolve($subjectAttributes, $objectAttributes, $configAttributes, $rule);
    }

    private function getRule($permission)
    {
        return $this->rules[$permission];
    }
}
