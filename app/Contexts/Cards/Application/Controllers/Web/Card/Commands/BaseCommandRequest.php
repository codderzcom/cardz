<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    public string $cardId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function rules()
    {
        return [
            //'cardId' => 'required'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->inferCardId();
        $this->merge([
            'cardId' => $this->cardId,
        ]);
    }

    protected function inferCardId(): void
    {
        $this->cardId = $this->route('cardId');
    }

    public function messages()
    {
        return [
            'cardId.required' => 'cardId required',
        ];
    }

}
