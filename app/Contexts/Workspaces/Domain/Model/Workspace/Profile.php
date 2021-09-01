<?php

namespace App\Contexts\Workspaces\Domain\Model\Workspace;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Profile
{
    private function __construct(
        public ?string $name,
        public ?string $description,
        public ?string $address,
    ) {
    }

    #[Pure] public static function create(?string $name, ?string $description, ?string $address): static
    {
        return new static($name, $description, $address);
    }

    public static function fromData($profile): static
    {
        if ($profile === null) {
            return new static(null, null, null);
        }
        if (is_array($profile)) {
            $data = $profile;
        } else {
            if (is_string($profile)) {
                $data = json_try_decode($profile, true);
            } else {
                $data = [];
            }
        }
        return new static(
            $data['name'] ?? null,
            $data['description'] ?? null,
            $data['address'] ?? null,
        );
    }

    #[Pure]
    #[ArrayShape(['name' => "null|string", 'description' => "null|string", 'address' => "null|string"])]
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
        ];
    }
}
