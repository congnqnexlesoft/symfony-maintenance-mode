<?php

namespace CongnqNexlesoft\MaintenanceMode\Console\Commands;

use CongnqNexlesoft\MaintenanceMode\Exceptions\FileException;
use Illuminate\Console\Command as IlluminateCommand;
use CongnqNexlesoft\MaintenanceMode\MaintenanceModeService;

abstract class Command extends IlluminateCommand
{
    /**
     * Maintenance Service.
     *
     * @var MaintenanceModeService
     */
    protected $maintenance;

    /**
     * @param MaintenanceModeService $maintenance
     */
    public function __construct(MaintenanceModeService $maintenance)
    {
        parent::__construct();

        $this->maintenance = $maintenance;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Set Application Up Mode.
     *
     * @return void
     * @throws FileException
     */
    public function setUpMode()
    {
        $this->maintenance->setUpMode();
        $this->info('Application is now live.');
    }

    /**
     * Set Application Down Mode.
     *
     * @return void
     * @throws FileException
     */
    public function setDownMode()
    {
        $this->maintenance->setDownMode();
        $this->info('Application is now in maintenance mode.');
    }
}
