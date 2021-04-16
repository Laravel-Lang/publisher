<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Facades\ArrayProcessor as ArrProcessor;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;

final class Packages
{
    use Logger;

    /**
     * Returns a sorted list of packages identified for processing.
     *
     * @return array
     */
    public function get(): array
    {
        $this->log('Getting a sorted list of packages identified for processing...');

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
        $this->log('Getting the number of processed packets...');

        return count($this->get());
    }
}
