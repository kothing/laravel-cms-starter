<?php

namespace Costar\LaravelFileManager\Exceptions;

class FileSizeExceedConfigurationMaximumException extends \Exception
{
    public function __construct($file_size)
    {
        $this->message = trans('laravel-file-manager::fileManager.error-size') . $file_size;
    }
}
