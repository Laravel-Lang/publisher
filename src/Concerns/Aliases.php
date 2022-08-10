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

namespace LaravelLang\Publisher\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Helpers\Config;

trait Aliases
{
    protected array $aliases = [];

    protected function fromAlias(LocaleCode|string|null $locale, Config $config): ?string
    {
        $locale = $locale?->value ?? $locale;

        if ($hashed = $this->aliases[$locale] ?? false) {
            return $hashed;
        }

        return $this->aliases[$locale] = Arr::of($config->getAliases())->flip()->get($locale);
    }

    protected function toAlias(LocaleCode|string|null $locale, Config $config): ?string
    {
        $locale = $locale?->value ?? $locale;

        if ($hashed = $this->aliases[$locale] ?? false) {
            return $hashed;
        }

        return $this->aliases[$locale] = Arr::get($config->getAliases(), $locale, $locale);
    }
}
