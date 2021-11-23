<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Builders;

use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Cards\Tests\Support\Builders\RequirementBuilder;
use App\Contexts\Collaboration\Tests\Support\Builders\InviteBuilder;
use App\Contexts\Collaboration\Tests\Support\Builders\RelationBuilder;
use App\Contexts\Identity\Tests\Support\Builders\UserBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\Environment;
use App\Contexts\Personal\Tests\Support\Builders\PersonBuilder;
use App\Contexts\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use App\Shared\Infrastructure\Tests\BaseBuilder;

class EnvironmentBuilder extends BaseBuilder
{
    private function __construct(
        protected CardBuilder $cardBuilder,
        protected InviteBuilder $inviteBuilder,
        protected PersonBuilder $personBuilder,
        protected RelationBuilder $relationBuilder,
        protected RequirementBuilder $requirementBuilder,
        protected UserBuilder $userBuilder,
        protected WorkspaceBuilder $workspaceBuilder,
    ) {
    }

    public function of(): static
    {
        return new static(
            CardBuilder::make(),
            InviteBuilder::make(),
            PersonBuilder::make(),
            RelationBuilder::make(),
            RequirementBuilder::make(),
            UserBuilder::make(),
            WorkspaceBuilder::make(),
        );
    }

    public function build(): Environment
    {
        return Environment::of();
    }

    public function generate(): static
    {
        return $this;
    }

}
