<?php

namespace CongnqNexlesoft\MaintenanceMode\Providers;

use Illuminate\Support\ServiceProvider;
use CongnqNexlesoft\MaintenanceMode\Console\Commands\DownCommand;
use CongnqNexlesoft\MaintenanceMode\Console\Commands\UpCommand;
use CongnqNexlesoft\MaintenanceMode\Http\Middleware\MaintenanceModeMiddleware;
use CongnqNexlesoft\MaintenanceMode\MaintenanceModeService;

class MaintenanceModeServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->middleware([
            MaintenanceModeMiddleware::class,
        ]);

        $this->app->singleton('maintenance', function () {
            return new MaintenanceModeService($this->app);
        });

        $this->app->singleton('command.up', function () {
            return new UpCommand($this->app['maintenance']);
        });

        $this->app->singleton('command.down', function () {
            return new DownCommand($this->app['maintenance']);
        });

        $this->commands(['command.up', 'command.down']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.up', 'command.down'];
    }
}
