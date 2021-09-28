<?php

namespace App\Shared\Contracts;

use MyCLabs\Enum\Enum;

/**
 * @method static ServiceResultCode OK();
 * @method static ServiceResultCode POLICY_VIOLATION();
 * @method static ServiceResultCode INTERNAL_ERROR();
 * @method static ServiceResultCode SUBJECT_NOT_FOUND();
 */
class ServiceResultCode extends Enum
{
    public const OK = 'Ok';
    public const POLICY_VIOLATION = 'Policy violation';
    public const INTERNAL_ERROR = 'Internal error';
    public const SUBJECT_NOT_FOUND = 'Not found';
}
