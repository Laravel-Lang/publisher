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

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class Jetstream extends BasePlugin
{
    public function vendor(): ?string
    {
        return 'laravel/jetstream';
    }

    public function files(): array
    {
        return [
            'packages/jetstream.json'     => '{locale}.json',
            'packages/jetstream-ext.json' => '{locale}.json',
        ];
    }
}
