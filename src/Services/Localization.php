<?php

namespace Helldar\LaravelLangPublisher\Services;

use Helldar\LaravelLangPublisher\Contracts\Process;
use Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException;
use Helldar\LaravelLangPublisher\Services\Processing\DeleteJson;
use Helldar\LaravelLangPublisher\Services\Processing\DeletePhp;
use Helldar\LaravelLangPublisher\Services\Processing\PublishJson;
use Helldar\LaravelLangPublisher\Services\Processing\PublishPhp;

final class Localization
{
    /** @var array */
    protected $result = [];

    /**
     * @param  string  $locale
     * @param  bool  $force
     * @param  bool  $json
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return array
     */
    public function publish(string $locale, bool $force = false, bool $json = false): array
    {
        return $json
            ? $this->process(PublishJson::class, $locale, $force)
            : $this->process(PublishPhp::class, $locale, $force);
    }

    /**
     * @param  string  $locale
     * @param  bool  $json
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return array
     */
    public function delete(string $locale, bool $json = false): array
    {
        return $json
            ? $this->process(DeleteJson::class, $locale)
            : $this->process(DeletePhp::class, $locale);
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
