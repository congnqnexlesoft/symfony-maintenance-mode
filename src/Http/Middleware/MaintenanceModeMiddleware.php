<?php

namespace CongnqNexlesoft\MaintenanceMode\Http\Middleware;

use Closure;
use CongnqNexlesoft\MaintenanceMode\MaintenanceModeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MaintenanceModeMiddleware
{
    /**
     * Maintenance Mode Service.
     *
     * @var MaintenanceModeService
     */
    protected $maintenance;

    /**
     * MaintenanceModeMiddleware constructor.
     * @param MaintenanceModeService $maintenance
     */
    public function __construct(MaintenanceModeService $maintenance)
    {
        $this->maintenance = $maintenance;
    }

    /**
     * Handle incoming requests.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function handle($request, Closure $next)
    {
        if ($this->maintenance->isDownMode() && !$this->maintenance->checkAllowedIp($this->getIp())) {
            // Response uses JSON (required config .env)
            if (strtolower(getenv('MAINTENANCE_RESPONSE_FORMAT')) === 'json') {
                return response()->json([
                    'success' => false,
                    'error' => 'UNDER_MAINTENANCE',
                    'message' => 'UNDER_MAINTENANCE',
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }
            // Response uses view
            if (app()['view']->exists('errors.503')) {
                return new Response(app()['view']->make('errors.503'), 503);
            }
            // Response uses others way
            if (config('maintenance')) {
                return response(config('maintenance')["response"], config('maintenance')["httpCode"]);
            } else {
                return app()->abort(503, 'The application is down for maintenance.');
            }
        }

        return $next($request);
    }

    /**
     * Get client ip
     */
    private function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
