<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Exceptions;

use LaravelLang\LocaleList\Locale;
use RuntimeException;

class UnknownLocaleCodeException extends RuntimeException
{
    public function __construct(Locale|string $locale)
    {
        parent::__construct('Unknown locale code: ' . $this->stringify($locale));
    }

    protected function stringify(Locale|string $locale): string
    {
        if ($locale instanceof Locale) {
            return $locale->value;
        }

        return $locale;
    }
}
