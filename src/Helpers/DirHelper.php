<?php

namespace CongnqNexlesoft\MaintenanceMode\Helpers;

class DirHelper
{
    /**
     * frameworks: Symfony 4.4, Laravel 5.8 and maybe Laravel higher version
     *
     * NOTEs: the paths are different between local and server (Docker) (dev,stg, prd)
     * .e.g issue
     * - PWD (local) = (no value) ,  PWD (server) = '/srv' (no /public)
     * - DOCUMENT_ROOT (local) =  "/Users/congnqnexlesoft/Desktop/engage-api/public" (have /public)
     * - DOCUMENT_ROOT (server) = "/srv" (no /public)
     * ---
     * use a field same part between local and server, like SCRIPT_FILENAME, and replace last part '/public/index.php'
     * - SCRIPT_FILENAME (local)  =  "/srv/legacy/public/index.php"
     * - SCRIPT_FILENAME (server) =  "/Users/congnqnexlesoft/Desktop/engage-api/public/index.php"
     *
     * @param string|null $subDirOrFile
     * @return string
     */
    public static function getWorkingDir(string $subDirOrFile = null): string
    {
        $workingDir = str_replace('/public/index.php', '', $_SERVER['SCRIPT_FILENAME']);
        return !$subDirOrFile  ? $workingDir : sprintf("%s/%s", $workingDir, $subDirOrFile);
    }
}
