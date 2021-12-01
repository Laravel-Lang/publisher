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

namespace LaravelLang\Publisher\Plugins;

use DragonCode\Contracts\LangPublisher\Provider;
use DragonCode\Support\Facades\Helpers\Arr;

abstract class BaseProvider implements Provider
{
    public function resolvePlugins(array $plugins): array
    {
        return Arr::map($plugins, static function (string $plugin) {
            return new $plugin();
        });
    }
}
