<?php

namespace Cardz\Support\Collaboration\Presentation\Controllers\Http\Invite\Commands;

use Cardz\Support\Collaboration\Application\Commands\Invite\DiscardInvite;
use Illuminate\Foundation\Http\FormRequest;

class DiscardInviteRequest extends FormRequest
{
    public string $inviteId;

    public function rules(): array
    {
        return [
            'inviteId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'inviteId.required' => 'inviteId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->inviteId = $this->input('inviteId');
    }

    public function toCommand(): DiscardInvite
    {
        return DiscardInvite::of($this->inviteId);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'inviteId' => $this->route('inviteId'),
        ]);
    }
}
