<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Comparators;

use Helldar\Contracts\LangPublisher\Comparator;

abstract class Base implements Comparator
{
    protected $keys = [];

    protected $translations = [];

    public function __construct(array $keys, array $translations)
    {
        $this->keys = $keys;

        $this->translations = $translations;
    }
}
