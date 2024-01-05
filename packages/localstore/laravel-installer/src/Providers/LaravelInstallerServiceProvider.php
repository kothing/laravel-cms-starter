<?php

namespace LocalStore\LaravelInstaller\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use LocalStore\LaravelInstaller\Middleware\canInstall;
use LocalStore\LaravelInstaller\Middleware\canUpdate;

class LaravelInstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    /**
     * Bootstrap the application events.
     *
     * @param  \Illuminate\Routing\Router  $router
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('install', [CanInstall::class]);
        $router->middlewareGroup('update', [CanUpdate::class]);
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__.'/../Config/installer.php' => base_path('config/installer.php'),
        ], 'laravel-installer');

        $this->publishes([
            __DIR__.'/../../public' => public_path('vendor/laravel-installer'),
        ], 'laravel-installer');

        $this->publishes([
            __DIR__.'/../Views' => base_path('resources/views/installer'),
        ], 'laravel-installer');

        $this->publishes([
            __DIR__.'/../Lang' => base_path('lang/vendor'),
        ], 'laravel-installer');
    }
}
