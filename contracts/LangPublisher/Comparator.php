<?php

declare(strict_types=1);

namespace Helldar\Contracts\LangPublisher;

interface Comparator
{
    public function __construct(array $keys, array $translations);

    public function get(): array;
}
