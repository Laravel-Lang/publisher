<?php

namespace Helldar\LaravelLangPublisher\Exceptions;

use Exception;

final class NoProcessInstanceException extends Exception
{
    public function __construct(string $classname)
    {
        parent::__construct("The \"{$classname}\" passed is not an instance of the process.", 500);
    }
}
