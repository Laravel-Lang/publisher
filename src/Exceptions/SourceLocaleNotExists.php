<?php

namespace Helldar\LaravelLangPublisher\Exceptions;

use Exception;

class SourceLocaleNotExists extends Exception
{
    public function __construct(string $locale)
    {
        parent::__construct("The source directory for \"{$locale}\" localization was not found.", 501);
    }
}
