<?php

namespace App\Contexts\Collaboration\Application\Controllers\Web\Invite\Commands;

use Illuminate\Foundation\Http\FormRequest;

final class InviteProposeRequest extends FormRequest
{
    public string $collaboratorId;
    public string $workspaceId;

    public function rules(): array
    {
        return [
            'collaboratorId' => 'required',
            'workspaceId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'collaboratorId.required' => 'collaboratorId required',
            'workspaceId.required' => 'workspaceId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->collaboratorId = $this->input('collaboratorId');
        $this->workspaceId = $this->input('workspaceId');
    }

}
