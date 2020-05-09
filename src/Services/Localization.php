<?php

namespace Helldar\LaravelLangPublisher\Services;

use function app;
use Helldar\LaravelLangPublisher\Contracts\Localization as LocalizationContract;
use Helldar\LaravelLangPublisher\Contracts\Process;
use Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException;
use Helldar\LaravelLangPublisher\Services\Processing\Delete;
use Helldar\LaravelLangPublisher\Services\Processing\DeleteJson;
use Helldar\LaravelLangPublisher\Services\Processing\Publish;
use Helldar\LaravelLangPublisher\Services\Processing\PublishJson;
use function is_subclass_of;

final class Localization implements LocalizationContract
{
    /** @var array */
    protected $result = [];

    /**
     * @param string $locale
     * @param bool $force
     * @param bool $json
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return array
     */
    public function publish(string $locale, bool $force = false, bool $json = false): array
    {
        return $json
            ? $this->process(PublishJson::class, $locale, $force)
            : $this->process(Publish::class, $locale, $force);
    }

    /**
     * @param string $locale
     * @param bool $json
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return array
     */
    public function delete(string $locale, bool $json = false): array
    {
        return $json
            ? $this->process(DeleteJson::class, $locale)
            : $this->process(Delete::class, $locale);
    }

    /**
     * @param string $classname
     * @param string $locale
     * @param bool $force
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
     * @param string $classname
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\NoProcessInstanceException
     *
     * @return \Helldar\LaravelLangPublisher\Contracts\Process
     */
    protected function makeProcess(string $classname): Process
    {
        if (! is_subclass_of($classname, Process::class)) {
            throw new NoProcessInstanceException($classname);
        }

        return app($classname);
    }
}
