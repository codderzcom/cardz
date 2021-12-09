<?php

namespace Cardz\Core\Plans\Application\Cli;

use Cardz\Core\Plans\Application\Commands\Plan\ArchivePlan;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Illuminate\Console\Command;

class ExpirePlans extends Command
{
    protected $signature = 'plans:expire';

    protected $description = 'Deactivate expired plans';

    public function __construct(
        private ReadPlanStorageInterface $readPlanStorage,
        private CommandBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ids = $this->readPlanStorage->getExpiredIds();
        foreach ($ids as $planId) {
            $this->commandBus->dispatch(ArchivePlan::of(PlanId::of($planId)));
        }
        return 0;
    }
}
