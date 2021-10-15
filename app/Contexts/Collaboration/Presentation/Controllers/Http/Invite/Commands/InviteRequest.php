<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands;

use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'inviteId' => $this->route('inviteId'),
        ]);
    }

}
