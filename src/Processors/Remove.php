<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Processors;

use DragonCode\Contracts\LangPublisher\Provider;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Facades\Support\Filesystem;

class Remove extends BaseProcessor
{
    protected $paths = [];

    public function handle(Provider $provider): void
    {
        foreach ($this->locales as $locale) {
            $json = $this->resourcesPath($locale . '.json');
            $php  = $this->resourcesPath($locale);

            $this->push($json, $php);
        }
    }

    public function finish(): void
    {
        Filesystem::delete($this->paths);
    }

    protected function prepareLocales(array $locales): array
    {
        $except = Locales::protects();

        return array_diff($locales, $except);
    }

    protected function push(string ...$paths): void
    {
        foreach ($paths as $path) {
            array_push($this->paths, $path);
        }
    }
}
