<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Queries;

use App\Contexts\Cards\Domain\CardId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BaseQuery extends FormRequest
{
    public ?CardId $cardId = null;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function withValidator(Validator $validator)
    {
        $this->cardId = new CardId($this->route('cardId'));
    }

    public function rules()
    {
        return [];
    }
}
