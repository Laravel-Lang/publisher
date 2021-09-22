<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
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
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Filesystem\File;

class Remove extends Base
{
    protected $signature = 'lang:rm'
    . ' {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Remove localizations.';

    protected $method = 'remove';

    public function handle()
    {
        foreach ($this->targetLocales() as $locale) {
            $this->removeDirectory($locale);
            $this->removeJson($locale);
        }
    }

    protected function removeDirectory(string $locale): void
    {
        $path = $this->resourcesPath($locale);

        Directory::ensureDelete($path);
    }

    protected function removeJson(string $locale): void
    {
        $path = $this->resourcesPath($locale . '.json');

        File::ensureDelete($path);
    }

    protected function targetLocales(): array
    {
        return $this->askLocales($this->method);
    }

    protected function getAllLocales(): array
    {
        return Locales::installed();
    }
}
