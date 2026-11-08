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

namespace Tests\Fixtures\Plugin\src\Plugins;

use LaravelLang\Publisher\Plugins\Plugin;

class Baq extends Plugin
{
    protected ?string $vendor = 'orchestra/testbench';

    protected string $version = '>=5.0';

    public function files(): array
    {
        return [
            'baq.json' => 'vendor/baq/{locale}.json',
        ];
    }
}
