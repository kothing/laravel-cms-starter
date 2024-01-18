<?php

declare(strict_types=1);

namespace Star\Support\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Gate;

/**
 * Class     AuthorizationServiceProvider

 */
abstract class AuthorizationServiceProvider extends AuthServiceProvider
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Define policies.
     *
     * @param  string  $class
     * @param  array   $policies
     */
    protected function defineMany($class, array $policies)
    {
        foreach ($policies as $ability => $method) {
            Gate::define($ability, "$class@$method");
        }
    }
}
