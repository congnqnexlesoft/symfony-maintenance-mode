<?php

namespace CongnqNexlesoft\MaintenanceMode\ConsoleCommand\MaintenanceMode;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownCommand extends Command
{
    public function __construct()
    {
        //
        parent::__construct('down');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('down');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo "down command handling";
    }
}
