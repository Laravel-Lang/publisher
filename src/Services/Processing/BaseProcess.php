<?php

namespace Helldar\LaravelLangPublisher\Services\Processing;

use function compact;
use Helldar\LaravelLangPublisher\Contracts\Process;

use Helldar\LaravelLangPublisher\Facades\File;

abstract class BaseProcess implements Process
{
    /** @var string */
    protected $locale;

    /** @var bool */
    protected $force;

    protected $result = [];

    public function locale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function force(bool $force = false): self
    {
        $this->force = $force;

        return $this;
    }

    public function result(): array
    {
        return $this->result;
    }

    protected function push(string $filename, string $status): void
    {
        $locale = $this->locale;

        $this->result[] = compact('locale', 'filename', 'status');
    }

    protected function checkExists(string $path): void
    {
        File::directoryExists($path, $this->locale);
    }
}
