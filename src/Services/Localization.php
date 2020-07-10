<?php

namespace Helldar\LaravelLangPublisher\Services;

use Helldar\LaravelLangPublisher\Contracts\Localizationable;
use Helldar\LaravelLangPublisher\Contracts\Pathable;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException;

final class Localization implements Localizationable
{
    /** @var \Helldar\LaravelLangPublisher\Contracts\Pathable */
    protected $path;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Processor */
    protected $processor;

    /** @var array */
    protected $result = [];

    public function setPath(Pathable $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function setProcessor(Processor $processor): self
    {
        $this->processor = $processor;

        return $this;
    }

    public function run(string $locale, bool $force = false): array
    {
        return $this->makeProcess($this->processor)
            ->locale($locale)
            ->force($force)
            ->run();
    }

    /**
     * @param  string  $processor
     * @param  string  $locale
     * @param  bool  $force
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return mixed
     */
    protected function process(Processor $processor, string $locale, bool $force = false)
    {
        return $this->makeProcess($processor)
            ->locale($locale)
            ->force($force)
            ->run();
    }

    /**
     * @param  string  $classname
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return Processor
     */
    protected function makeProcess(string $classname): Processor
    {
        if (! is_subclass_of($classname, Processor::class)) {
            throw new NoProcessInstanceException($classname);
        }

        return app($classname);
    }
}
