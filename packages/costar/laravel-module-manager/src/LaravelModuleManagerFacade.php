<?php

namespace Costar\LaravelModuleManager;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Costar\LaravelModuleManager\Skeleton\SkeletonClass
 */
class LaravelModuleManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-module-manager';
    }
}
