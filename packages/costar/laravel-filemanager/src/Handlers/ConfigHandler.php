<?php

namespace Star\LaravelFilemanager\Handlers;

class ConfigHandler
{
    public function userField()
    {
        return auth()->id();
    }
}
