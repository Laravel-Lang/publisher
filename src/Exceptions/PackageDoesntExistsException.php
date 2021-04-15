<?php

namespace Helldar\LaravelLangPublisher\Exceptions;

use RuntimeException;

final class PackageDoesntExistsException extends RuntimeException
{
    public function __construct(string $package)
    {
        parent::__construct('The "' . $package . '" package is not a translation repository or does not exist.');
    }
}
