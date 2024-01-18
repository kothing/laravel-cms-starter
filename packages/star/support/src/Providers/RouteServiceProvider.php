<?php

declare(strict_types=1);

namespace Star\Support\Providers;

use Star\Support\Routing\Concerns\RegistersRouteClasses;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as IlluminateServiceProvider;

/**
 * Class     RouteServiceProvider

 */
abstract class RouteServiceProvider extends IlluminateServiceProvider
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use RegistersRouteClasses;
}
