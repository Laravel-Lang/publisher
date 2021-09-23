<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Comparators;

use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\LaravelLangPublisher\Facades\Support\Filter;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;

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

    protected function excludes(string $filename, array $user): array
    {
        foreach (Config::excludes() as $key => $values) {
            if (Str::contains($filename, $key)) {
                return Arr::only($user, $values);
            }
        }

        return [];
    }
}
