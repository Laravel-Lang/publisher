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

namespace LaravelLang\Lang\Publisher\Plugins;

use LaravelLang\Publisher\Plugins\BasePlugin;

class Nova extends BasePlugin
{
    public function vendor(): ?string
    {
        return 'laravel/nova';
    }

    public function files(): array
    {
        return [
            'packages/nova.json' => 'vendor/nova/{locale}.json',
        ];
    }
}
