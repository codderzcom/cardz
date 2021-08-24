<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Queries;

use App\Contexts\Cards\Domain\CardId;
use Illuminate\Http\Request;

class BaseQuery extends Request
{
    public CardId $cardId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        dd($this);
    }
}
