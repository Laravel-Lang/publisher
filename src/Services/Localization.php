<?php

namespace Helldar\LaravelLangPublisher\Services;

use Helldar\LaravelLangPublisher\Contracts\Localizationable;
use Helldar\LaravelLangPublisher\Contracts\Pathable;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Traits\Containable;

final class Localization implements Localizationable
{
    use Containable;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Pathable */
    protected $path;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Processor */
    protected $processor;

    /** @var array */
    protected $result = [];

    public function setPath(Pathable $path): Localizationable
    {
        $this->path = $path;

        return $this;
    }

    public function setProcessor(Processor $processor): Localizationable
    {
        $this->processor = $processor;

        return $this;
    }

    public function run(string $locale, bool $force = false): array
    {
        return $this->processor
            ->locale($locale)
            ->force($force)
            ->run();
    }
}
