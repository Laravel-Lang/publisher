<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Facades\ArrayProcessor as ArrProcessor;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;

final class Packages
{
    /**
     * Returns a sorted list of packages identified for processing.
     *
     * @return array
     */
    public function get(): array
    {
        $packages = ConfigFacade::packages();

        return ArrProcessor::of($packages)
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }
}
