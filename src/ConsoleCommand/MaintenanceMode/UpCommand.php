<?php

namespace CongnqNexlesoft\MaintenanceMode\ConsoleCommand\MaintenanceMode;

use CongnqNexlesoft\MaintenanceMode\MaintenanceModeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class UpCommand extends Command
{
    const COMMAND = 'up';

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
        $this->setDescription("Bring the application out of maintenance mode.'");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // handle
        //    Bring the application out of maintenance mode.
        if ($this->maintenance->isDownMode()) {
            $this->setUpMode($input,$output);
        } else {
            $output->writeln('<info>The application was already alive.</info>');
        }
    }

    /**
     * Set Application Up Mode.
     * @return void
     * @throws FileNotFoundException
     */
    public function setUpMode(InputInterface $input, OutputInterface $output)
    {
        $this->maintenance->setUpMode();
        $output->writeln('<info>Application is now live.</info>');
    }
}
