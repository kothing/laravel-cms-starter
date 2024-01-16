<?php

namespace Costar\LaravelFileManager\Exceptions;

class InvalidMimeTypeException extends \Exception
{
    public function __construct($mimetype)
    {
        $this->message = trans('laravel-file-manager::fileManager.error-mime') . $mimetype;
    }
}
