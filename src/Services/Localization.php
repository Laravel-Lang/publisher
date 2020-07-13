<?php

namespace Helldar\LaravelLangPublisher\Services;

use Helldar\LaravelLangPublisher\Contracts\Localizationable;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Traits\Containable;

final class Localization implements Localizationable
{
    use Containable;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Processor */
    protected $processor;

    /** @var array */
    protected $result = [];

    /** @var bool */
    protected $is_force = false;

    /** @var bool */
    protected $is_full = false;

    public function processor(Processor $processor): Localizationable
    {
        $this->processor = $processor;

        return $this;
    }

    public function force(bool $is_force = true): Localizationable
    {
        $this->is_force = $is_force;

        return $this;
    }

    public function full(bool $is_full = true): Localizationable
    {
        $this->is_full = $is_full;

        return $this;
    }

    public function run(string $locale): array
    {
        return $this->processor
            ->locale($locale)
            ->force($this->is_force)
            ->full($this->is_full)
            ->run();
    }
}
