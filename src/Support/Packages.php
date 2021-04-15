<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;
use Helldar\Support\Facades\Helpers\Arr as ArrHelper;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

final class Packages
{
    use Pathable;

    public function filtered(): array
    {
        $packages = $this->all();
        $unique   = $this->unique($packages);
        $filtered = $this->filter($unique);
        $sorted   = $this->sort($filtered);

        return $this->values($sorted);
    }

    public function all(): array
    {
        return ConfigFacade::packages();
    }

    protected function filter(array $packages): array
    {
        return array_filter($packages, static function ($package) {
            $source = $this->pathSource($package, LocalesList::ENGLISH);
            $target = $this->pathSource($package, LocalesList::RUSSIAN);

            return Directory::exists($source) && Directory::exists($target);
        });
    }

    protected function unique(array $packages): array
    {
        return array_unique($packages);
    }

    protected function values(array $packages): array
    {
        return array_values($packages);
    }

    protected function sort(array $packages): array
    {
        return ArrHelper::sort($packages);
    }
}
