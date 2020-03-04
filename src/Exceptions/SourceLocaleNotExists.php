<?php

namespace Helldar\LaravelLangPublisher\Exceptions;

use Exception;

final class SourceLocaleNotExists extends Exception
{
    public function __construct(string $classname)
    {
        parent::__construct("The source directory for \"{$classname}\" localization was not found.", 501);
    }
}
