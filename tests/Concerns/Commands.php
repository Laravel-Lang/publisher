<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests\Concerns;

use LaravelLang\LocaleList\Locale;

trait Commands
{
    protected function artisanLangAdd(array|Locale|string|null $locales = null, bool $set = false): void
    {
        is_null($locales)
            ? $this->artisan('lang:add')->run()
            : $this->artisan('lang:add', compact('locales'))->run();

        $set
            ? $this->setAppLocale(Locale::German)
            : $this->reloadLocales();
    }

    protected function artisanLangRemove(array|Locale|string|null $locales = null, bool $force = false): void
    {
        is_null($locales)
            ? $this->artisan('lang:rm', ['--force' => $force])->run()
            : $this->artisan('lang:rm', array_merge(['--force' => $force], compact('locales')))->run();

        $this->reloadLocales();
    }

    protected function artisanLangUpdate(): void
    {
        $this->artisan('lang:update')->run();

        $this->reloadLocales();
    }

    protected function reloadLocales(): void
    {
        $this->app['translator']->setLoaded([]);
    }
}
