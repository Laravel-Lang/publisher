<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\Concerns;

use LaravelLang\Publisher\Constants\Locales;

trait Commands
{
    protected function artisanLangAdd(Locales|array|string|null $locales = null, bool $set = false): void
    {
        is_null($locales)
            ? $this->artisan('lang:add')->run()
            : $this->artisan('lang:add', compact('locales'))->run();

        $set
            ? $this->setAppLocale(Locales::GERMAN)
            : $this->reloadLocales();
    }

    protected function artisanLangRemove(Locales|array|string|null $locales = null, bool $force = false): void
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
