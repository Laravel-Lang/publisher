<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Comparators;

use Helldar\LaravelLangPublisher\Facades\Support\Filter;
use Helldar\Support\Facades\Helpers\Arr;

class Add extends Base
{
    public function get(): array
    {
        foreach ($this->filenames() as $filename) {
            $user = $this->load($filename);

            $translated = $this->translations[$filename];

            $excludes = $this->excludes($filename, $user);

            $this->translations[$filename] = $this->merge($translated, $user, $excludes);
        }

        return $this->filter();
    }

    protected function filter(): array
    {
        return Filter::keys($this->keys)
            ->translated($this->translations)
            ->get();
    }

    protected function merge(array $translated, array $user, array $excludes): array
    {
        return Arr::merge($user, $translated, $excludes);
    }

    protected function filenames(): array
    {
        return array_keys($this->keys);
    }
}
