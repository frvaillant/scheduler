<?php

namespace App\Command;

use App\Service\Commands\SchedulerTestCommandService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Scheduler\Attribute\AsPeriodicTask;

#[AsCommand(
    name: 'schedule',
    description: 'Creates a file or add 1 to its last number. Test periodic task',
)]
#[AsPeriodicTask(frequency: 20)]
class ScheduleCommand extends Command
{
    const string FILENAME = 'index.txt';

    public function __construct(private readonly SchedulerTestCommandService $commandService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandService->execute(self::FILENAME);

        return Command::SUCCESS;
    }
}
