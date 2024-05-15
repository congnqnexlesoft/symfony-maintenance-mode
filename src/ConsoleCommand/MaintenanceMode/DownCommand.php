<?php

namespace CongnqNexlesoft\MaintenanceMode\ConsoleCommand\MaintenanceMode;

use CongnqNexlesoft\MaintenanceMode\MaintenanceModeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class DownCommand extends Command
{
    const COMMAND = 'down';

    /**
     * Maintenance Service.
     * @var MaintenanceModeService
     */
    protected $maintenance;

    /**
     * @param MaintenanceModeService $maintenance
     */
    public function __construct(MaintenanceModeService $maintenance)
    {
        $this->maintenance = $maintenance;
        //
        parent::__construct(self::COMMAND);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND);
        $this->setDescription("Put the application into maintenance mode.");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // handle
        //    Put the application into maintenance mode.
        if ($this->maintenance->isUpMode()) {
            $this->setDownMode($input, $output);
        } else {
            $output->writeln('<comment>The application is already in maintenance mode!</comment>');
        }
    }

    /**
     * Set Application Down Mode.
     * @return void
     * @throws FileNotFoundException
     */
    public function setDownMode(InputInterface $input, OutputInterface $output)
    {
        $this->maintenance->setDownMode();
        $output->writeln('<comment>Application is now in maintenance mode.</comment>');
    }
}
