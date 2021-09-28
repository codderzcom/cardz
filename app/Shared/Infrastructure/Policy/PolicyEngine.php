<?php

namespace App\Shared\Infrastructure\Policy;

use App\Shared\Contracts\PolicyAssertionInterface;
use App\Shared\Contracts\PolicyEngineInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use Closure;
use Throwable;

class PolicyEngine implements PolicyEngineInterface
{
    public function __construct(
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function passTrough(Closure $closure, PolicyAssertionInterface ...$policies): ServiceResultInterface
    {
        foreach ($policies as $policy) {
            if (!$policy->assert()) {
                return $this->serviceResultFactory->violation(
                    substr(strrchr('\\' . get_class($policy), '\\'), 1) . ' violated: ' . $policy->violation()
                );
            }
        }
        try {
            $result = $closure();
        } catch (Throwable $exception) {
            return $this->serviceResultFactory->error($exception->getMessage());
        }
        return $result instanceof ServiceResultInterface ? $result : $this->serviceResultFactory->ok($result);
    }

}
