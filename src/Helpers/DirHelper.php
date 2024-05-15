<?php

namespace CongnqNexlesoft\MaintenanceMode\Helpers;

class DirHelper
{
    /**
     * Last updated on May 15, 2024
     * ---
     * Support frameworks: Symfony 4.4, Laravel 5.8 and maybe Laravel higher version
     * ---
     * - #1.1 The paths are different between local and server (Docker) (dev,stg, prd)
     * .e.g issue
     * - PWD (local) = (no value) ,  PWD (server) = '/srv' (no /public)
     * - DOCUMENT_ROOT (local) =  "/Users/congnqnexlesoft/Desktop/engage-api/public" (have /public)
     * - DOCUMENT_ROOT (server) = "/srv" (no /public)
     * ---
     * - #1.2 Use a field same part between local and server, like SCRIPT_FILENAME, and replace last part '/public/index.php'
     * - SCRIPT_FILENAME (local)  =  "/srv/legacy/public/index.php"
     * - SCRIPT_FILENAME (server) =  "/Users/congnqnexlesoft/Desktop/engage-api/public/index.php"
     * ---
     * - #3 Console command
     *    - in Symfony,
     *        - in Mac, SCRIPT_FILENAME will return 'bin/console' , PWD = dir path
     *        - in Docker image, same Mac
     *    - in Laravel,
     *        - in Mac, SCRIPT_FILENAME will return 'artisan' , PWD = dir path
     *        - in Docker image, same Mac
     * ---
     * @param string|null $subDirOrFile
     * @return string
     */
    public static function getWorkingDir(string $subDirOrFile = null): string
    {
        // case: Console command
        if (in_array($_SERVER['SCRIPT_FILENAME'], ['bin/console', 'artisan'])) {
            return $_SERVER['PWD'];
        }
        // case: PHP request
        $workingDir = str_replace('/public/index.php', '', $_SERVER['SCRIPT_FILENAME']);
        return !$subDirOrFile ? $workingDir : sprintf("%s/%s", $workingDir, $subDirOrFile);
    }
}
