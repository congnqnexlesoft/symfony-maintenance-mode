<?php

namespace CongnqNexlesoft\MaintenanceMode;

use CongnqNexlesoft\MaintenanceMode\Helpers\DirHelper;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class MaintenanceModeService
{
    /**
     * File to verify maintenance mode. In Symfony, will put the file at 'public/down'
     * @var string
     */
    protected $maintenanceFile = 'public/down';

    public function __construct()
    {
    }

    /**
     * Verify if application is in maintenance mode.
     * @return bool
     */
    public function isDownMode(): bool
    {
        return $this->maintenanceFileExists();
    }

    /**
     * Indicates if maintenance file exists.
     * @return bool
     */
    public function maintenanceFileExists(): bool
    {
        return file_exists($this->maintenanceFilePath());
    }

    /**
     * Maintenance file path.
     * @return string
     */
    public function maintenanceFilePath(): string
    {
        return DirHelper::getWorkingDir($this->maintenanceFile);
    }

    /**
     * Verify if application is up.
     * @return bool
     */
    public function isUpMode(): bool
    {
        return !$this->maintenanceFileExists();
    }

    /**
     * Put the application in down mode.
     * @return bool true if success and false if something fails.
     * @throws FileNotFoundException
     *
     */
    public function setDownMode(): bool
    {
        $file = $this->maintenanceFilePath();
        if (!touch($file)) {
            throw new FileNotFoundException(sprintf('Something went wrong on trying to create maintenance file %s.', $file));
        }
        return true;
    }

    /**
     * Put application in up mode.
     * @return bool true if success and false if something fails.
     * @throws FileNotFoundException
     *
     */
    public function setUpMode(): bool
    {
        $file = $this->maintenanceFilePath();
        if (file_exists($file) && !unlink($file)) {
            throw new FileNotFoundException(sprintf('Something went wrong on trying to remove maintenance file %s.', $file));
        }
        return true;
    }
}
