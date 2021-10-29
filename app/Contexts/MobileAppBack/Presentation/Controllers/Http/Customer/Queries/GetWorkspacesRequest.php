<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries;

use App\Contexts\MobileAppBack\Application\Queries\Customer\GetWorkspaces;
use Illuminate\Foundation\Http\FormRequest;

final class GetWorkspacesRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function toQuery(): GetWorkspaces
    {
        return GetWorkspaces::of();
    }
}
