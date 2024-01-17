<?php

namespace Star\LaravelFilemanager\Exceptions;

class EmptyFileException extends \Exception
{
    public function __construct()
    {
        $this->message = trans('laravel-filemanager::lfm.error-file-empty');
    }
}
