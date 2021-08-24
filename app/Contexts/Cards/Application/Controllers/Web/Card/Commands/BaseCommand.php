<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

use App\Contexts\Cards\Domain\CardId;
use Illuminate\Http\Request;

class BaseCommand extends Request
{
    public CardId $cardId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->cardId = new CardId($this->route()?->parameter('cardId'));
    }
}
