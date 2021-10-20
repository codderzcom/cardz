<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Relation\Commands;

use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelation;
use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelationCommandInterface;
use Illuminate\Foundation\Http\FormRequest;

final class RelationRequest extends FormRequest
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

    public function toCommand(): LeaveRelationCommandInterface
    {
        return LeaveRelation::of($this->collaboratorId, $this->workspaceId);
    }
}
