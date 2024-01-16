<?php

namespace Costar\LaravelFilemanager\Handlers;

class ConfigHandler
{
    public function userField()
    {
        return auth()->id();
    }
}
