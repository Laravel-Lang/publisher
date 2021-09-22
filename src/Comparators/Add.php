<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Comparators;

use Helldar\LaravelLangPublisher\Facades\Support\Filter;

class Add extends Base
{
    public function get(): array
    {
        return $this->filter();
    }

    protected function filter(): array
    {
        return Filter::keys($this->keys)
            ->translated($this->translations)
            ->get();
    }
}
