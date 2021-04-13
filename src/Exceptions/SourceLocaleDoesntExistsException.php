<?php

namespace Helldar\LaravelLangPublisher\Exceptions;

use RuntimeException;

final class SourceLocaleDoesntExistsException extends RuntimeException
{
    public function __construct(string $locale)
    {
        parent::__construct('The source "' . $locale . '" localization was not found.');
    }
}
