<?php

namespace Costar\LaravelFileManager\Exceptions;

class FileSizeExceedIniMaximumException extends \Exception
{
    public function __construct()
    {
        $this->message = trans('laravel-file-manager::fileManager.error-file-size', ['max' => ini_get('upload_max_filesize')]);
    }
}
