<?php

namespace Cardz\Support\Collaboration\Presentation\Controllers\Http\Invite\Commands;

use Cardz\Support\Collaboration\Application\Commands\Invite\AcceptInvite;
use Illuminate\Foundation\Http\FormRequest;

class AcceptInviteRequest extends FormRequest
{
    public string $inviteId;

    public string $collaboratorId;

    public function rules(): array
    {
        return [
            'inviteId' => 'required',
            'collaboratorId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'inviteId.required' => 'inviteId required',
            'collaboratorId.required' => 'collaboratorId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->inviteId = $this->input('inviteId');
        $this->collaboratorId = $this->input('collaboratorId');
    }

    public function toCommand(): AcceptInvite
    {
        return AcceptInvite::of($this->inviteId, $this->collaboratorId);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'inviteId' => $this->route('inviteId'),
        ]);
    }

}
