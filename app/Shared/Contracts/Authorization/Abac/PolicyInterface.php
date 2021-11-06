<?php

namespace App\Shared\Contracts\Authorization\Abac;

interface PolicyInterface
{
    public function apply(SubjectInterface $subject, ObjectInterface $object, SystemInterface $system): bool;
}
