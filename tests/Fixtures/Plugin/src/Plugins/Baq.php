<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2022 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

namespace Tests\Fixtures\Plugin\src\Plugins;

use LaravelLang\Publisher\Plugins\Plugin;

class Baq extends Plugin
{
    protected ?string $vendor = 'orchestra/testbench';

    protected string $version = '^5.0 || ^6.0 || ^7.0';

    public function files(): array
    {
        return [
            'baq.json' => 'vendor/baq/{locale}.json',
        ];
    }
}
