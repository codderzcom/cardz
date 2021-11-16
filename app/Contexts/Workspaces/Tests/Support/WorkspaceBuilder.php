<?php

namespace App\Contexts\Workspaces\Tests\Support;

use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

final class WorkspaceBuilder extends BaseBuilder
{
    private string $workspaceId;

    private string $keeperId;

    private string $name;

    private string $description;

    private string $address;

    private Carbon $added;

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
