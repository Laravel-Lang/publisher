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
            ->values()
            ->toArray();
    }

    /**
     * Returns the count of processable packages.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->get());
    }
}
