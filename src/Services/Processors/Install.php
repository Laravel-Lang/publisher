<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;

final class Install extends Processor
{
    public function run(): void
    {
        $source = $this->load($this->getSourcePath());
        $target = $this->load($this->getTargetPath());

        $this->sort($source);
        $this->sort($target);

        $merged = $this->merge($source, $target);

        $this->store($this->target, $merged);
    }

    protected function merge(array $source, array $target): array
    {
        return $this->isValidation()
            ? $this->mergeValidation($source, $target)
            : $this->mergeBasic($source, $target);
    }

    protected function mergeBasic(array $source, array $target): array
    {
        return array_merge($source, $target);
    }

    protected function mergeValidation(array $source, array $target): array
    {
        $custom     = $this->getFallbackValue($source, $target, 'custom');
        $attributes = $this->getFallbackValue($source, $target, 'attributes');

        $source = Arr::except($source, ['custom', 'attributes']);
        $target = Arr::except($target, ['custom', 'attributes']);

        return array_merge($source, $target, compact('custom', 'attributes'));
    }

    protected function isValidation(): bool
    {
        return Str::contains($this->filename($this->target), 'validation');
    }

    protected function hasInline(): bool
    {
        return Config::hasInline();
    }

    protected function getSourcePath(): string
    {
        if ($this->isValidation() && $this->hasInline()) {
            $directory = $this->directory($this->source);
            $filename  = $this->filename($this->source);
            $extension = $this->extension($this->source);

            return $directory . '/' . $filename . '-inline.' . $extension;
        }

        return $this->source;
    }

    protected function getTargetPath(): string
    {
        return $this->target;
    }
}
