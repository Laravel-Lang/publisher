<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Keyable;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Facades\Packages as PackagesSupport;
use Helldar\Support\Facades\Helpers\Arr as ArrSupport;

final class Info
{
    use Contains;
    use Keyable;
    use Logger;

    protected $styles = [
        Status::COPIED  => 'fg=green',
        Status::RESET   => 'fg=magenta',
        Status::SKIPPED => 'fg=default',
        Status::DELETED => 'fg=red',
    ];

    protected $package;

    protected $locale;

    protected $locales_length = 0;

    protected $filename;

    protected $files_length = 0;

    public function same(): self
    {
        return $this;
    }

    public function package(string $package): self
    {
        $this->package = $package;

        return $this;
    }

    public function locale(string $locale, int $length): self
    {
        $this->locale         = $locale;
        $this->locales_length = $length;

        return $this;
    }

    public function filename(string $filename, int $length): self
    {
        $this->filename     = $filename;
        $this->files_length = $length;

        return $this;
    }

    public function start(): string
    {
        return $this->getPackage() . $this->getLocale() . $this->getFilename();
    }

    public function finish(string $status): string
    {
        return $this->getStatus($status);
    }

    protected function getPackage(): ?string
    {
        if (! $this->hasPackages()) {
            return null;
        }

        $value = $this->pad($this->package, $this->packagesLength());

        return $this->format($value, 'fg=#a6a6a6');
    }

    protected function getLocale(): string
    {
        $value = $this->pad("[$this->locale]", $this->locales_length + 2);

        return $this->format($value, 'comment');
    }

    protected function getFilename(): string
    {
        $value = $this->pad($this->filename . '...', $this->files_length + 3);

        return $this->format($value);
    }

    protected function getStatus(string $status): string
    {
        $style = $this->styles[$status];

        return $this->format($status, $style);
    }

    protected function hasPackages(): bool
    {
        return PackagesSupport::count() > 1;
    }

    protected function packagesLength(): int
    {
        $packages = PackagesSupport::get();

        return ArrSupport::longestStringLength($packages);
    }

    protected function pad(string $value, int $length): string
    {
        return str_pad($value, $length + 1);
    }

    protected function format(string $value, string $style = null): string
    {
        return $style ? "<$style>$value</>" : $value;
    }
}
