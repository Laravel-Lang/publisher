<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\ArrayProcessor as ArrProcessor;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

final class Packages
{
    use Pathable;

    /**
     * Returns a list of packets taking into account filtering.
     *
     * @return array
     */
    public function filtered(): array
    {
        $packages = $this->all();

        return $this->map($packages);
    }

    /**
     * Returns the entire list of packages without filtering and sorting.
     *
     * @return array
     */
    public function all(): array
    {
        $packages = ConfigFacade::packages();

        return ArrProcessor::of($packages)->sort()->toArray();
    }

    protected function filter(): callable
    {
        return function ($package) {
            $source = $this->pathSource($package, LocalesList::ENGLISH);
            $target = $this->pathSource($package, LocalesList::RUSSIAN);

            return Directory::exists($source) && Directory::exists($target);
        };
    }

    protected function map(array $packages): array
    {
        return ArrProcessor::of($packages)
            ->unique()
            ->filter($this->filter())
            ->values()
            ->sort()
            ->toArray();
    }
}
