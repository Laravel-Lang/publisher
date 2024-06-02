<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Concerns;

use Composer\InstalledVersions;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Foundation\Console\AboutCommand;
use LaravelLang\Config\Facades\Config;

trait About
{
    protected function registerAbout(): void
    {
        $this->pushInformation(fn () => [
            'Publisher Version' => $this->getPackageVersion('laravel-lang/publisher'),
        ]);

        $this->pushInformation(fn () => $this->getPackages());
    }

    protected function pushInformation(callable $data): void
    {
        AboutCommand::add('Locales', $data);
    }

    protected function getPackages(): array
    {
        return Arr::of(Config::hidden()->packages->all())
            ->renameKeys(static fn (mixed $key, array $values) => $values['class'])
            ->map(fn (array $values) => $this->getPackageVersion($values['name']))
            ->toArray();
    }

    protected function getPackageVersion(string $package): string
    {
        if (InstalledVersions::isInstalled($package)) {
            return InstalledVersions::getPrettyVersion($package);
        }

        return '<fg=yellow;options=bold>INCORRECT</>';
    }

    protected function implodeLocales(array $locales): string
    {
        return Arr::of($locales)->sort()->implode(', ')->toString();
    }
}
