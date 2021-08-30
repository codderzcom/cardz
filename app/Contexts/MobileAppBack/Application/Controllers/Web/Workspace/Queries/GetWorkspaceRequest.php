<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class GetWorkspaceRequest extends FormRequest
{
    public string $workspaceId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function withValidator(Validator $validator): void
    {
        $this->workspaceId = $this->route('workspaceId');
    }

    public function rules()
    {
        return [];
    }
}
