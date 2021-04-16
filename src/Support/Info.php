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

    protected $packages_length = 0;

    protected $locale;

    protected $locales_length = 0;

    protected $filename;

    protected $files_length = 0;

    public function same(): self
    {
        return $this;
    }

    public function package(?string $package): self
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
        $this->log('Return formatted message text for', $this->package, $this->locale, $this->filename);

        return $this->getPackage() . $this->getLocale() . $this->getFilename();
    }

    public function finish(string $status): string
    {
        $this->log('Returning the completed state for', $this->package, $this->locale, $this->filename, $status);

        return $this->getStatus($status);
    }

    protected function getPackage(): ?string
    {
        $this->log('Get rich text of a message with a package name:', $this->package);

        if (! $this->package || ! $this->hasPackages()) {
            $this->log('The package name was not transmitted or the number of processed packages is not more than one. Processing is skipped.');

            return null;
        }

        $value = $this->pad($this->package, $this->packagesLength());

        return $this->format($value, 'fg=#a6a6a6');
    }

    protected function getLocale(): string
    {
        $this->log('Get rich text of a message with a locale:', $this->locale);

        $value = $this->pad("[$this->locale]", $this->locales_length + 2);

        return $this->format($value, 'comment');
    }

    protected function getFilename(): string
    {
        $this->log('Get rich text of a message with a filename:', $this->filename);

        $value = $this->pad($this->filename . '...', $this->files_length + 3);

        return $this->format($value);
    }

    protected function getStatus(string $status): string
    {
        $this->log('Get rich text of a message with a status:', $status);

        $style = $this->styles[$status];

        return $this->format($status, $style);
    }

    protected function hasPackages(): bool
    {
        $this->log('Checking the number of packages available for processing...');

        return PackagesSupport::count() > 1;
    }

    protected function packagesLength(): int
    {
        $this->log('Retrieving the maximum number of packet characters...');

        if ($this->packages_length > 0) {
            return $this->packages_length;
        }

        $this->log('Calculating the maximum length of a packages names...');

        $packages = PackagesSupport::get();

        return $this->packages_length = ArrSupport::longestStringLength($packages);
    }

    protected function pad(string $value, int $length): string
    {
        $this->log('Pad a string to a certain length with another string:', $value, $length);

        return str_pad($value, $length + 1);
    }

    protected function format(string $value, string $style = null): string
    {
        $this->log('String formatting:', $value, $style);

        return $style ? "<$style>$value</>" : $value;
    }
}
