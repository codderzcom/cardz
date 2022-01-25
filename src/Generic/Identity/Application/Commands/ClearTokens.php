<?php

namespace Cardz\Generic\Identity\Application\Commands;

use Cardz\Generic\Identity\Domain\Model\User\UserId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

final class ClearTokens implements CommandInterface
{
    private function __construct(
        private string $userId,
        private bool $exceptLast,
    ) {
    }

    public static function of(string $userId, bool $exceptLast = true): self
    {
        return new self($userId, $exceptLast);
    }

    public function getUserId(): UserId
    {
        return UserId::of($this->userId);
    }

    public function exceptLast(): bool
    {
        return $this->exceptLast;
    }
}
