<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Card\Queries;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{
    public string $cardId;

    public function rules(): array
    {
        return [
            'cardId' => 'required',
        ];
    }

    public function passedValidation(): void
    {
        $this->cardId = $this->input('cardId');
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cardId' => $this->route('cardId'),
        ]);
    }
}
