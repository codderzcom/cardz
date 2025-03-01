<?php

namespace Cardz\Support\MobileAppGateway\Domain\ReadModel\Customer;

use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

final class IssuedCard implements JsonSerializable
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $cardId,
        string $workspaceName,
        string $workspaceAddress,
        public string $customerId,
        public string $description,
        public bool $satisfied,
        public bool $completed,
        public array $achievements,
        public array $requirements,
    ) {
    }

    /**
     * @param string[] $achievements
     * @param string[] $requirements
     */
    #[Pure]
    public static function make(
        string $cardId,
        string $workspaceName,
        string $workspaceAddress,
        string $customerId,
        string $description,
        bool $satisfied,
        bool $completed,
        array $achievements,
        array $requirements,
    ): self {
        return new self(
            $cardId,
            $workspaceName,
            $workspaceAddress,
            $customerId,
            $description,
            $satisfied,
            $completed,
            $achievements,
            $requirements,
        );
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
