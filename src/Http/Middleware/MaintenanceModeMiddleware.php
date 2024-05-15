<?php

namespace CongnqNexlesoft\MaintenanceMode\Http\Middleware;

use CongnqNexlesoft\MaintenanceMode\Helpers\DirHelper;
use CongnqNexlesoft\MaintenanceMode\MaintenanceModeService;
use CongnqNexlesoft\MaintenanceMode\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class MaintenanceModeMiddleware
{
    use ResponseTrait;

    /** @var MaintenanceModeService */
    private $maintenanceModeService;

    /**
     * @param MaintenanceModeService $maintenanceModeService
     */
    public function __construct(
        MaintenanceModeService $maintenanceModeService
    )
    {
        $this->maintenanceModeService = $maintenanceModeService;
    }

    public function onRequest(RequestEvent $event)
    {
        if ($this->maintenanceModeService->isDownMode()) {
            // Response uses JSON (required config .env)
            if (strtolower(getenv('MAINTENANCE_RESPONSE_FORMAT')) === 'json') {
                $this->forceResponseJson([
                    'success' => false,
                    'error' => 'UNDER_MAINTENANCE',
                    'message' => 'UNDER_MAINTENANCE',
                ], Response::HTTP_SERVICE_UNAVAILABLE); // END
            }
            // Response uses view
            $this->forceResponse($this->render503ViewManually(), Response::HTTP_SERVICE_UNAVAILABLE); // END
        }
    }

    /**
     * @return string
     */
    private function render503ViewManually(): string
    {
        return str_replace("{{ appName }}", getenv('APP_NAME'), file_get_contents(
            DirHelper::getWorkingDir('vendor/congnqnexlesoft/symfony-maintenance-mode/src/templates/errors/503.html.twig')
        ));
    }
}
