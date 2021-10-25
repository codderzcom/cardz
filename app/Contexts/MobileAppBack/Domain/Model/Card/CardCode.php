<?php

namespace App\Contexts\MobileAppBack\Domain\Model\Card;

use App\Contexts\MobileAppBack\Domain\Exceptions\ReconstructionException;
use Carbon\Carbon;
use DateInterval;
use JetBrains\PhpStorm\Pure;
use Throwable;

final class CardCode
{
    private const SPLIT_MARKER = '.';

    private const EXPIRATION_INTERVAL = 'PT15M';

    private Carbon $expires;

    private function __construct(private CardId $cardId)
    {
        $this->expires = Carbon::now()->add(new DateInterval(self::EXPIRATION_INTERVAL));
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

    private function setExpires(Carbon $expires): self
    {
        $this->expires = $expires;
        return $this;
    }

    public function isExpired(): bool
    {
        Carbon::now()->gt($this->expires);
    }

    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getCode();
    }

    public function getCode(): string
    {
        return base64_encode($this->expires) . self::SPLIT_MARKER . base64_encode($this->cardId);
    }
}
