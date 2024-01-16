<?php

namespace App\Handlers;

class FileManagerConfigHandler extends \Costar\LaravelFileManager\Handlers\ConfigHandler
{
    public function userField()
    {
        return parent::userField();
    }
}
