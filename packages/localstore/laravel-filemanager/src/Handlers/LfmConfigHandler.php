<?php

namespace App\Handlers;

class LfmConfigHandler extends \LocalStore\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
        return parent::userField();
    }
}
