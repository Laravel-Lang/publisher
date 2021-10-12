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

namespace Tests\Concerns;

trait TestKeys
{
    protected $trans_prefix;

    protected $items = [];

    protected function trans(string $key, string $locale = null): string
    {
        $key = $this->trans_prefix . $key;

        return trans($key, [], $locale);
    }

    protected function testSame(string $expected, string $key, string $locale = null): void
    {
        $message = static::class . ': ' . $this->trans_prefix . $key;

        $this->assertSame($expected, $this->trans($key, $locale), $message);
    }
}
