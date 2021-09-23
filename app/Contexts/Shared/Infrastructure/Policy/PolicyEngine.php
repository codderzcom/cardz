<?php

namespace App\Contexts\Shared\Infrastructure\Policy;

use App\Contexts\Shared\Contracts\PolicyAssertionInterface;
use App\Contexts\Shared\Contracts\PolicyEngineInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
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
