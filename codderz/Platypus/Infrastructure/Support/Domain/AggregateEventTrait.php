<?php

namespace Codderz\Platypus\Infrastructure\Support\Domain;

use Carbon\Carbon;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\ShortClassNameTrait;
use ReflectionClass;

trait AggregateEventTrait
{
    use ShortClassNameTrait;

    protected  string $context;

    protected  string $channel;

    protected  GenericIdInterface $stream;

    protected  int $version = 1;

    protected  Carbon $at;

    protected AggregateRootInterface $aggregateRoot;

    private array $exclude = [
        'context',
        'channel',
        'stream',
        'version',
        'at',
        'aggregateRoot',
    ];

    public function context(): string
    {
        return $this->context;
    }

    public function channel(): string
    {
        return $this->channel;
    }

    public function stream(): GenericIdInterface
    {
        return $this->stream;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function changeset(): array
    {
        $changeset = [];
        $class = new ReflectionClass($this);
        $properties = $class->getProperties();
        $excluded = $this->getExcludedPropertyNames();
        foreach ($properties as $property) {
            $name = $property->getName();
            $property->setAccessible(true);
            if (!in_array($name, $excluded, true)) {
                $changeset[$property->getName()] = $property->getValue($this);
            }
        }
        return $changeset;
    }

    public function at(): Carbon
    {
        return $this->at;
    }

    public function in(AggregateRootInterface $aggregateRoot): static
    {
        $this->at ??= Carbon::now();
        $this->aggregateRoot = $aggregateRoot;
        return $this;
    }

    protected function getExcludedPropertyNames(): array
    {
        return $this->exclude;
    }

}
