<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

use App\Contexts\Cards\Domain\Model\Card\CardId;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    public CardId $cardId;

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
    }

    protected function inferCardId(): void
    {
        $this->cardId = new CardId($this->route('cardId'));
    }
}
