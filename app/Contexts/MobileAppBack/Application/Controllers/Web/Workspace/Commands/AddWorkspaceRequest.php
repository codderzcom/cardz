<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

use Illuminate\Foundation\Http\FormRequest;

final class AddWorkspaceRequest extends FormRequest
{
    public string $customerId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    protected function passedValidation(): void
    {
        $this->customerId = '1';
    }

    public function rules()
    {
        return [
        ];
    }

}
