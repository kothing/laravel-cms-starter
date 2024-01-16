<?php

namespace Costar\LaravelFileManager\Exceptions;

class ExcutableFileException extends \Exception
{
    public function __construct()
    {
        $this->message = 'Invalid file detected';
    }
}
