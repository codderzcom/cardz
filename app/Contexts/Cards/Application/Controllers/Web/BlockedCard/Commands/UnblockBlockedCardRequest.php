<?php

namespace App\Contexts\Cards\Application\Controllers\Web\BlockedCard\Commands;

use Illuminate\Foundation\Http\FormRequest;

final class UnblockBlockedCardRequest extends FormRequest
{
    public string $blockedCardId;

    public function rules(): array
    {
        return [
            'blockedCardId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'blockedCardId.required' => 'blockedCardId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->blockedCardId = $this->input('blockedCardId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'blockedCardId' => $this->route('blockedCardId'),
        ]);
    }

}
