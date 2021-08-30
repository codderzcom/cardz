<?php

namespace App\Contexts\MobileAppBack\Application\Contracts;

use MyCLabs\Enum\Enum;

/**
 * @method static ApplicationServiceResultCode OK();
 * @method static ApplicationServiceResultCode POLICY_VIOLATION();
 * @method static ApplicationServiceResultCode INTERNAL_ERROR();
 * @method static ApplicationServiceResultCode SUBJECT_NOT_FOUND();
 */
class ApplicationServiceResultCode extends Enum
{
    public const OK = 'Ok';
    public const POLICY_VIOLATION = 'Policy violation';
    public const INTERNAL_ERROR = 'Internal error';
    public const SUBJECT_NOT_FOUND = 'Not found';
}
