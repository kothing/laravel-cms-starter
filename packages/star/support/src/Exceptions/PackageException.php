<?php

declare(strict_types=1);

namespace Star\Support\Exceptions;

use Exception;

/**
 * Class     PackageException

 */
class PackageException extends Exception
{
    public static function unspecifiedName(): self
    {
        return new static('You must specify the vendor/package name.');
    }
}
