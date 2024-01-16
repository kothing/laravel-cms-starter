<?php

namespace Costar\LaravelFileManager\Exceptions;

class EmptyFileException extends \Exception
{
    public function __construct()
    {
        $this->message = trans('laravel-file-manager::fileManager.error-file-empty');
    }
}
