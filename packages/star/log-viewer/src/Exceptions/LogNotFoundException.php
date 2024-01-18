<?php

declare(strict_types=1);

namespace Star\LogViewer\Exceptions;

/**
 * Class     LogNotFoundException
 */
class LogNotFoundException extends LogViewerException
{
    /**
     * Make the exception.
     *
     * @param  string  $date
     *
     * @return static
     */
    public static function make(string $date)
    {
        return new static("Log not found in this date [{$date}]");
    }
}
