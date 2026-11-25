<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Loaders;

use Illuminate\Container\Attributes\Config;
use Illuminate\Support\Str;
use LaravelLang\Filesystem\Filesystem;

use function array_replace;
use function array_unshift;
use function in_array;
use function str_replace;

class TranslationLoader
{
    /**
     * @param  array<string>  $styles
     * @param  array<string>  $skip
     */
    public function __construct(
        #[Config('localization_main.styles')]
        protected array $styles,
        #[Config('localization_main.skip')]
        protected array $skip,
        protected Filesystem $filesystem,
    ) {}

    /** @return array<array-key, mixed> */
    public function get(string $directory, string $locale): array
    {
        $result = [];

        foreach ($this->styles() as $style) {
            $path = $this->path($directory, $locale, $style);

            if ($this->needSkip($path)) {
                continue;
            }

            $result[] = $this->filesystem->fromJson($path);
        }

        return array_replace([], ...$result);
    }

    /** @return array<string> */
    protected function styles(): array
    {
        if (! in_array('default', $this->styles, true)) {
            array_unshift($this->styles, 'default');
        }

        return $this->styles;
    }

    protected function path(string $directory, string $locale, string $style): string
    {
        return $directory . '/locales/' . $locale . '/' . $style . '.json';
    }

    protected function needSkip(string $path): bool
    {
        $prepared = str_replace('\\', '/', $path);

        return Str::is($this->skip, $prepared, true);
    }
}
