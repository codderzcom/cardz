<?php

namespace Cardz\Generic\Authorization\Domain\Attribute;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeInterface;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;

final class Attribute implements AttributeInterface
{
    public const SUBJECT_ID = 'subjectId';
    public const KEEPER_ID = 'keeperId';
    public const COLLABORATOR_ID = 'collaboratorId';
    public const CUSTOMER_ID = 'customerId';
    public const USER_ID = 'userId';
    public const MEMBER_IDS = 'memberIds';

    public const WORKSPACE_ID = 'workspaceId';
    public const PLAN_ID = 'planId';
    public const CARD_ID = 'cardId';
    public const RELATION_ID = 'relationId';
    public const RELATION_TYPE = 'relationType';

    use ArrayPresenterTrait;

    public function __construct(
        private string $name,
        private $value,
    ) {
    }

    public static function of(string $name, $value): self
    {
        return new self($name, $value);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }

    public function equals($value): bool
    {
        return $this->value === $value;
    }

    public function contains($value): bool
    {
        if (is_array($this->value)) {
            return in_array($value, $this->value);
        }
        return false;
    }
}
