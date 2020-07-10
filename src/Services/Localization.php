<?php

namespace Helldar\LaravelLangPublisher\Services;

use function app;
use Helldar\LaravelLangPublisher\Contracts\Process;
use Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException;
use Helldar\LaravelLangPublisher\Services\Processing\Delete;

use Helldar\LaravelLangPublisher\Services\Processing\Publish;

final class Localization
{
    /** @var array */
    protected $result = [];

    /**
     * @param  string  $locale
     * @param  bool  $force
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return array
     */
    public function publish(string $locale, bool $force = false): array
    {
        return $this->process(Publish::class, $locale, $force);
    }

    /**
     * @param  string  $locale
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return array
     */
    public function delete(string $locale): array
    {
        return $this->process(Delete::class, $locale);
    }

    /**
     * @param  string  $classname
     * @param  string  $locale
     * @param  bool  $force
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return mixed
     */
    protected function process(string $classname, string $locale, bool $force = false)
    {
        return $this->makeProcess($classname)
            ->locale($locale)
            ->force($force)
            ->run();
    }

    /**
     * @param  string  $classname
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return Process
     */
    protected function makeProcess(string $classname): Process
    {
        if (! is_subclass_of($classname, Process::class)) {
            throw new NoProcessInstanceException($classname);
        }

        return app($classname);
    }
}
