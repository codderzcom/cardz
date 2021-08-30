<?php

namespace App\Contexts\Workspaces\Application\Controllers\Web\Workspace\Commands;

use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    public WorkspaceId $workspaceId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function rules()
    {
        return [
            //'workspaceId' => 'required'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->inferWorkspaceId();
    }

    protected function inferWorkspaceId(): void
    {
        $this->workspaceId = new WorkspaceId($this->route('workspaceId'));
    }
}
