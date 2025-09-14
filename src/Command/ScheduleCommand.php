<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Scheduler\Attribute\AsPeriodicTask;

#[AsCommand(
    name: 'schedule',
    description: 'Creates a file and add 1 to its content. Test periodic task',
)]
#[AsPeriodicTask(frequency: 20)]
class ScheduleCommand extends Command
{
    private string $folder;

    const string FILENAME = 'index.json';

    public function __construct(KernelInterface $kernel)
    {
        parent::__construct();
        $this->folder = $kernel->getProjectDir() . '/public/files/';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $filesystem = new Filesystem();
        $filesystem->mkdir($this->folder);

        $number = 0;

        if($filesystem->exists($this->folder . self::FILENAME)) {

            $content = json_decode(
                $filesystem->readFile($this->folder . self::FILENAME)
            );

            $number = $content->number;
        }

        $number++;

        $filesystem->dumpFile(
            $this->folder . self::FILENAME,
            json_encode(['number' => $number])
        );

        return Command::SUCCESS;
    }
}
