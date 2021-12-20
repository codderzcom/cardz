<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Eloquent;

use App\Models\Card as EloquentCard;
use Cardz\Support\MobileAppGateway\Domain\ReadModel\Customer\IssuedCard;
use Cardz\Support\MobileAppGateway\Infrastructure\Exceptions\IssuedCardNotFoundException;
use Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Contracts\IssuedCardReadStorageInterface;
use function json_try_decode;

class IssuedCardReadStorage implements IssuedCardReadStorageInterface
{
    public function allForCustomer(string $customerId): array
    {
        /** @var EloquentCard $card */
        $cards = EloquentCard::query()
            ->where('customer_id', '=', $customerId)
            ->whereNull('revoked_at')
            ->whereNull('blocked_at')
            ->get();
        $issuedCards = [];
        foreach ($cards as $card) {
            $issuedCards[] = $this->issuedCardFromEloquent($card);
        }

        return $issuedCards;
    }

    public function forCustomer(string $customerId, string $cardId): IssuedCard
    {
        /** @var EloquentCard $card */
        $card = EloquentCard::query()
            ->where('id', '=', $cardId)
            ->where('customer_id', '=', $customerId)
            ->whereNull('revoked_at')
            ->whereNull('blocked_at')
            ->first();
        if ($card === null) {
            throw new IssuedCardNotFoundException("Card: $cardId. Customer: $customerId");
        }

        return $this->issuedCardFromEloquent($card);
    }

    private function issuedCardFromEloquent(EloquentCard $card): IssuedCard
    {
        $achievements = is_string($card->achievements) ? json_try_decode($card->achievements, true) : $card->achievements;
        $requirements = is_string($card->requirements) ? json_try_decode($card->requirements, true) : $card->requirements;

        return IssuedCard::make(
            $card->id,
            $card->plan_id,
            $card->customer_id,
            $card->description,
            $card->satisfied_at !== null,
            $card->completed_at !== null,
            $achievements,
            $requirements
        );
    }

}
