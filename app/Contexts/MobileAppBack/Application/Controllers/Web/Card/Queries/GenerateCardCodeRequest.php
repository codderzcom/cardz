<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Card\Queries;

use App\Contexts\MobileAppBack\Domain\Card\CardId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class GenerateCardCodeRequest extends FormRequest
{
    public CardId $cardId;

    public function withValidator(Validator $validator): void
    {
        $this->cardId = CardId::of($this->route('cardId') ?? '');
    }

    public function rules()
    {
        return [];
    }
}
