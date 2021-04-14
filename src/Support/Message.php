<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Keyable;
use Helldar\LaravelLangPublisher\Concerns\Logger;

final class Message
{
    use Contains;
    use Keyable;
    use Logger;

    protected $locales_length = 0;

    protected $files_length = 0;

    protected $locale;

    protected $filename;

    protected $status;

    public function same(): self
    {
        return $this;
    }

    public function length(int $locales, int $files): self
    {
        $this->locales_length = abs($locales) + 3;
        $this->files_length   = abs($files) + 4;

        return $this;
    }

    public function locale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function filename(string $filename): self
    {
        $this->filename = $this->key($filename);

        return $this;
    }

    public function status(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function get(): string
    {
        return $this->getLocale() . $this->getFilename() . $this->getStatus();
    }

    protected function pad(string $value, int $length): string
    {
        return str_pad($value, $length);
    }

    protected function getLocale(): string
    {
        $value = $this->pad("[$this->locale]", $this->locales_length);

        return $this->format($value, 'comment');
    }

    protected function getFilename(): string
    {
        $value = $this->pad($this->filename . '...', $this->files_length);

        return $this->format($value);
    }

    protected function getStatus(): string
    {
        return $this->format($this->status, 'info');
    }

    protected function format(string $value, string $style = null): string
    {
        return $style ? "<$style>$value</$style>" : $value;
    }
}
