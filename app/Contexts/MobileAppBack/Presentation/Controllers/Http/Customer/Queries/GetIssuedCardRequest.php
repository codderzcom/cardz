<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries;

use App\Contexts\MobileAppBack\Application\Queries\Customer\GetIssuedCard;
use Illuminate\Foundation\Http\FormRequest;

final class GetIssuedCardRequest extends FormRequest
{
    public string $customerId;

    public string $cardId;

    public function rules(): array
    {
        return [
            'customerId' => 'required',
            'cardId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'customerId.required' => 'customerId required',
            'cardId.required' => 'cardId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->customerId = $this->input('customerId');
        $this->cardId = $this->input('cardId');
    }

    public function toQuery(): GetIssuedCard
    {
        return GetIssuedCard::of($this->customerId, $this->cardId);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'customerId' => $this->user()->id,
            'cardId' => $this->route('cardId'),
        ]);
    }
}
