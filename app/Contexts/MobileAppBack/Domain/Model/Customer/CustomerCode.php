<?php

namespace App\Contexts\MobileAppBack\Domain\Model\Customer;

use App\Contexts\MobileAppBack\Domain\Exceptions\ReconstructionException;
use Carbon\Carbon;
use DateInterval;
use JetBrains\PhpStorm\Pure;
use Throwable;

final class CustomerCode
{
    private Carbon $expires;

    private const SPLIT_MARKER = '.';

    private const EXPIRATION_INTERVAL = 'PT15M';

    private function __construct(private CustomerId $customerId)
    {
        $this->expires = Carbon::now()->add(new DateInterval(self::EXPIRATION_INTERVAL));
    }

    private function setExpires(Carbon $expires): self
    {
        $this->expires = $expires;
        return $this;
    }

    public static function ofCustomerId(CustomerId $customerId): static
    {
        return new self($customerId);
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
            $customerId = CustomerId::of(base64_decode($idString));
            return (new self($customerId))->setExpires($date);
        } catch (Throwable) {
            throw new ReconstructionException();
        }
    }

    public function isExpired(): bool
    {
        Carbon::now()->gt($this->expires);
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getCode(): string
    {
        return base64_encode($this->expires) . self::SPLIT_MARKER . base64_encode($this->customerId);
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getCode();
    }
}
