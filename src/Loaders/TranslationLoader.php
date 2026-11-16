<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Loaders;

use Illuminate\Container\Attributes\Config;
use LaravelLang\Filesystem\Filesystem;

use function array_merge;
use function array_unshift;
use function in_array;

class TranslationLoader
{
    public function __construct(
        #[Config('localization_main.styles')]
        protected array $styles,
        protected Filesystem $filesystem,
    ) {}

    public function get(string $directory, string $locale): array
    {
        $result = [];

        foreach ($this->styles() as $style) {
            $result[] = $this->filesystem->fromJson(
                path: $directory . '/locales/' . $locale . '/' . $style . '.json'
            );
        }

        return array_merge(...$result);
    }

    protected function styles(): array
    {
        if (! in_array('default', $this->styles, true)) {
            array_unshift($this->styles, ['default']);
        }

        return $this->styles;
    }
}
