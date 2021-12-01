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

namespace Tests\InlineOn\Console\Keys;

use Tests\Concerns\TestKeys;
use Tests\InlineOnTestCase;

abstract class BaseJsonTestCase extends InlineOnTestCase
{
    use TestKeys;

    public function testFallback()
    {
        foreach (array_keys($this->items) as $key) {
            $this->testSame($key, $key);
        }
    }

    public function testInstalled()
    {
        $this->artisan('lang:add', ['locales' => $this->locale])->run();

        $this->refreshLocales();

        foreach ($this->items as $en => $ru) {
            $this->testSame($ru, $en, $this->locale);
        }
    }
}
