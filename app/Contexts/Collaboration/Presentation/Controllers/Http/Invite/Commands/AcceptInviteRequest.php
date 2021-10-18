<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInvite;
use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInviteCommandInterface;
use Illuminate\Foundation\Http\FormRequest;

class AcceptInviteRequest extends FormRequest
{
    public string $inviteId;

    public string $memberId;

    public string $workspaceId;

    public function rules(): array
    {
        return [
            'inviteId' => 'required',
            'memberId' => 'required',
            'workspaceId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'inviteId.required' => 'inviteId required',
            'memberId.required' => 'memberId required',
            'workspaceId.required' => 'workspaceId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->inviteId = $this->input('inviteId');
        $this->memberId = $this->input('memberId');
        $this->workspaceId = $this->input('workspaceId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'inviteId' => $this->route('inviteId'),
        ]);
    }

    public function toCommand(): AcceptInviteCommandInterface
    {
        return AcceptInvite::of($this->inviteId, $this->memberId, $this->workspaceId);
    }

}
