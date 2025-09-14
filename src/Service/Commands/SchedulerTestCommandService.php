<?php

namespace App\Service\Commands;

use phpDocumentor\Reflection\File;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class SchedulerTestCommandService
{

    /**
     * @var string The folder where to store files
     */
    private string $folder;

    private Filesystem $filesystem;

    public function __construct(KernelInterface $kernel)
    {
        $this->folder = $kernel->getProjectDir() . '/public/files/';
        $this->filesystem = new Filesystem();

        $this->filesystem->mkdir($this->folder);
    }

    /**
     * @param string $fileName
     * @return void
     *
     */
    public function execute(string $fileName): void
    {

        $number = 0;

        if($this->filesystem->exists($this->folder . $fileName)) {
            $content = str_split($this->filesystem->readFile($this->folder . $fileName));
            $number  = end($content);
            $number++;
        }

        $this->addContentToFile($number, $fileName);
    }

    private function addContentToFile(int $number, string $fileName): void
    {
        $path = $this->folder . $fileName;

        if ($number === 10) {
            $this->filesystem->dumpFile($path, 0);
            return;
        }

        $this->filesystem->appendToFile($path, $number);
    }

}
