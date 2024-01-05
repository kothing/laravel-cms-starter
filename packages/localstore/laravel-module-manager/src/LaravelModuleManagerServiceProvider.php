<?php

namespace LocalStore\LaravelModuleManager;

use Illuminate\Support\ServiceProvider;
use LocalStore\LaravelModuleManager\Commands\LaravelModuleBuildCommand;
use LocalStore\LaravelModuleManager\Commands\TestCommand;

class LaravelModuleManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-module-manager');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-module-manager');
        // $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('module-manager.php'),
            ], 'laravel-module-manager');

            $this->publishes([
                __DIR__.'/stubs' => base_path('stubs/laravel-starter-stubs'),
            ], 'laravel-module-manager');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-module-manager'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-module-manager'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-module-manager'),
            ], 'lang');*/

            /**
             * Registering package commands.
             * Register the command if we are using the application via the CLI.
             */
            if ($this->app->runningInConsole()) {
                $this->commands([
                    // TestCommand::class,
                    LaravelModuleBuildCommand::class,
                ]);
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-module-manager');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-module-manager', function () {
            return new ModuleManager();
        });
    }
}
