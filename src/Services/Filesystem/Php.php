<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\PrettyArray\Services\File as Pretty;
use Helldar\PrettyArray\Services\Formatter;

final class Php extends Filesystem
{
    public function load(string $path): array
    {
        if ($this->doesntExists($path)) {
            return [];
        }

        $items = Pretty::make()->load($path);

        return $this->correctValues($items);
    }

    public function store(string $path, array $content)
    {
        $service = Formatter::make();

        $this->setCase($service);
        $this->setAlignment($service);

        Pretty::make($service->raw($content))->store($path);
    }

    protected function isAlignment(): bool
    {
        return Config::hasAlignment();
    }

    protected function setCase(Formatter $formatter): void
    {
        $formatter->setCase(Config::getCase());
    }

    protected function setAlignment(Formatter $formatter): void
    {
        if ($this->isAlignment()) {
            $formatter->setEqualsAlign();
        }
    }
}
