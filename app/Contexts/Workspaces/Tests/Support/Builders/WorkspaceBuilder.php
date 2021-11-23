<?php

namespace App\Contexts\Workspaces\Tests\Support\Builders;

use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

final class WorkspaceBuilder extends BaseBuilder
{
    public string $workspaceId;

    public string $keeperId;

    public string $name;

    public string $description;

    public string $address;

    public Carbon $added;

    public function build(): Workspace
    {
        return Workspace::restore(
            $this->workspaceId,
            $this->keeperId,
            $this->added,
            [
                'name' => $this->name,
                'description' => $this->description,
                'address' => $this->address,
            ],
        );
    }

    public function withKeeperId(string $keeperId): static
    {
        $this->keeperId = $keeperId;
        return $this;
    }

    public function generate(): static
    {
        $this->workspaceId = WorkspaceId::makeValue();
        $this->keeperId = KeeperId::makeValue();
        $this->name = $this->faker->name();
        $this->description = $this->faker->text();
        $this->address = $this->faker->address();
        $this->added = Carbon::now();
        return $this;
    }

}
