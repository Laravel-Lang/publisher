<?php

namespace Helldar\LaravelLangPublisher\Services;

use Helldar\LaravelLangPublisher\Contracts\Localization as LocalizationContract;
use Helldar\LaravelLangPublisher\Contracts\Process;
use Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException;
use Helldar\LaravelLangPublisher\Services\Processing\Delete;
use Helldar\LaravelLangPublisher\Services\Processing\Publish;

use function app;

final class Localization implements LocalizationContract
{
    /** @var array */
    protected $result = [];

    /**
     * @param string $locale
     * @param bool $force
     *
     * @return array
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     */
    public function publish(string $locale, bool $force = false): array
    {
        return $this->process(Publish::class, $locale, $force);
    }

    /**
     * @param string $locale
     *
     * @return array
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     */
    public function delete(string $locale): array
    {
        return $this->process(Delete::class, $locale);
    }

    /**
     * @param string $classname
     * @param string $locale
     * @param bool $force
     *
     * @return mixed
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     */
    protected function process(string $classname, string $locale, bool $force = false)
    {
        return $this->makeProcess($classname)
            ->locale($locale)
            ->force($force)
            ->run();
    }

    /**
     * @param string $classname
     *
     * @return \Helldar\LaravelLangPublisher\Contracts\Process
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     */
    protected function makeProcess(string $classname): Process
    {
        if (! is_subclass_of($classname, Process::class)) {
            throw new NoProcessInstanceException($classname);
        }

        return app($classname);
    }
}
