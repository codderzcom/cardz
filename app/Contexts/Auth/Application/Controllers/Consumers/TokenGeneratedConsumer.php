<?php

namespace App\Contexts\Auth\Application\Controllers\Consumers;

use App\Contexts\Auth\Application\IntegrationEvents\TokenGenerated;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;

final class TokenGeneratedConsumer implements Informable
{
    public function __construct()
    {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof TokenGenerated;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var TokenGenerated $event */
        $event = $reportable;
        /** @var Model $tokenModel */
        $tokenModel = Sanctum::$personalAccessTokenModel;
        $token = $tokenModel::query()->where('tokenable_id', '=', $event->id())->latest()->first();
        if ($token === null) {
            return;
        }
        $tokenModel::query()
            ->where('tokenable_id', '=', $event->id())
            ->where('name', '=', $token->name)
            ->whereNotIn('id', [$token->id])
            ->delete();
    }

}
