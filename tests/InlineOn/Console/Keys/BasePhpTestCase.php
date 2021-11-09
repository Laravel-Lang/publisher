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

namespace Tests\InlineOn\Console\Keys;

use Tests\Concerns\TestKeys;
use Tests\InlineOnTestCase;

abstract class BasePhpTestCase extends InlineOnTestCase
{
    use TestKeys;

    public function testFallback()
    {
        foreach ($this->items as $key => $values) {
            $this->testSame($values[0], $key);
        }
    }

    public function testInstalled()
    {
        $this->artisan('lang:add', ['locales' => $this->locale])->run();

        $this->refreshLocales();

        foreach ($this->items as $key => $values) {
            $this->testSame($values[1], $key, $this->locale);
        }
    }
}
