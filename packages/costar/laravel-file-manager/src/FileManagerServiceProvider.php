<?php

namespace Costar\LaravelFileManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class FileManagerServiceProvider.
 */
class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'laravel-file-manager');

        $this->loadViewsFrom(__DIR__.'/views', 'laravel-file-manager');

        $this->publishes([
            __DIR__ . '/config/config.php' => base_path('config/file-manager.php'),
        ], 'fileManager_config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/laravel-file-manager'),
        ], 'fileManager_public');

        $this->publishes([
            __DIR__.'/views'  => base_path('resources/views/vendor/laravel-file-manager'),
        ], 'fileManager_view');

        $this->publishes([
            __DIR__.'/Handlers/FileManagerConfigHandler.php' => base_path('app/Handlers/FileManagerConfigHandler.php'),
        ], 'fileManager_handler');

        if (config('fileManager.use_package_routes')) {
            Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth']], function () {
                \Costar\LaravelFileManager\FileManager::routes();
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'fileManager-config');

        $this->app->singleton('laravel-file-manager', function () {
            return true;
        });
    }
}
