<?php

namespace Helldar\LaravelLangPublisher\Exceptions;

use RuntimeException;

final class NoProcessInstanceException extends RuntimeException
{
    public function __construct(string $classname)
    {
        parent::__construct("The \"{$classname}\" passed is not an instance of the process.");
    }
}
