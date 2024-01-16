<?php

namespace Costar\LaravelFileManager\Handlers;

class ConfigHandler
{
    public function userField()
    {
        return auth()->id();
    }
}
