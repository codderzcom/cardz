<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Card\Queries;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class GenerateCardCodeRequest extends FormRequest
{
    public string $cardId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function withValidator(Validator $validator): void
    {
        $this->cardId = $this->route('cardId');
    }

    public function rules()
    {
        return [];
    }
}
