<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Model\Entity;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Achievement extends Entity
{
    private function __construct(
        public AchievementId $achievementId,
        public string $description
    ) {
    }

    #[Pure]
    #[ArrayShape(['id' => "string", 'description' => "string"])]
    public function toArray(): array
    {
        return [
            'id' => (string) $this->achievementId,
            'description' => $this->description,
        ];
    }
}

