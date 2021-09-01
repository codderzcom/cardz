<?php

namespace App\Contexts\MobileAppBack\Domain\Card;

use App\Contexts\MobileAppBack\Domain\Exceptions\ReconstructionException;
use Carbon\Carbon;
use DateInterval;
use JetBrains\PhpStorm\Pure;
use Throwable;

final class CardCode
{
    private Carbon $expires;

    private const SPLIT_MARKER = '.';

    private const EXPIRATION_INTERVAL = 'PT15M';

    private function __construct(private CardId $cardId)
    {
        $this->expires = Carbon::now()->add(new DateInterval(self::EXPIRATION_INTERVAL));
    }

    private function setExpires(Carbon $expires): self
    {
        $this->expires = $expires;
        return $this;
    }

    public static function ofCardId(CardId $cardId): static
    {
        return new self($cardId);
    }

    /**
     * @throws ReconstructionException
     */
    public static function ofCodeString(string $code): static
    {
        try {
            $codeValues = explode(static::SPLIT_MARKER, $code);
            if (!is_array($codeValues) || count($codeValues) !== 2) {
                throw new ReconstructionException();
            }
            [$dateString, $idString] = $codeValues;

            $date = Carbon::parse(base64_decode($dateString));
            $cardId = CardId::of(base64_decode($idString));
            return (new self($cardId))->setExpires($date);
        } catch (Throwable) {
            throw new ReconstructionException();
        }
    }

    public function isExpired(): bool
    {
        Carbon::now()->gt($this->expires);
    }

    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    public function getCode(): string
    {
        return base64_encode($this->expires) . self::SPLIT_MARKER . base64_encode($this->cardId);
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getCode();
    }
}
