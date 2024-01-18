<?php

namespace Star\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Star\Modules\Contracts\RepositoryInterface;
use Star\Modules\Laravel\LaravelFileRepository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, LaravelFileRepository::class);
    }
}
