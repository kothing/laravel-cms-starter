<?php

declare(strict_types=1);

namespace Star\LogViewer\Exceptions;

/**
 * Class     FilesystemException
 */
class FilesystemException extends LogViewerException
{
    public static function cannotDeleteLog()
    {
        return new static('There was an error deleting the log.');
    }

    public static function invalidPath(string $path)
    {
        return new static("The log(s) could not be located at : $path");
    }
}
