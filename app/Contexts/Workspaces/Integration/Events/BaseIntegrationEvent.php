<?php

namespace App\Contexts\Workspaces\Integration\Events;

use App\Shared\Contracts\Reportable;

abstract class BaseIntegrationEvent implements Reportable
{
    protected string $in = 'N/A';

    protected string $of = 'N/A';

    public function __construct(
        protected string $id
    ) {
    }

    public function __toString(): string
    {
        return substr(strrchr('\\' . get_class($this), '\\'), 1)
            . ' in  ' . $this->in
            . ' of ' . $this->of;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function payload(): array
    {
        return [
            'id' => $this->id,
            'of' => $this->of,
            'in' => $this->in,
        ];
    }
}
