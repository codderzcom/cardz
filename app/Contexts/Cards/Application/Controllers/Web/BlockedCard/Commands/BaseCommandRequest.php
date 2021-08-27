<?php

namespace App\Contexts\Cards\Application\Controllers\Web\BlockedCard\Commands;

use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCardId;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    public BlockedCardId $blockedCardId;

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
        $this->blockedCardId = new BlockedCardId($this->route('blockedCardId'));
    }
}
