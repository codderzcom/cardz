<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

final class ChangeWorkspaceProfileRequest extends FormRequest
{
    public string $workspaceId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    protected function withValidator(Validator $validator): void
    {
        $this->workspaceId = $this->route('workspaceId');
    }

    public function rules()
    {
        return [
        ];
    }

}
