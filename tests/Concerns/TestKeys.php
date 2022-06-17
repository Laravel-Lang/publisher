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

namespace Tests\Concerns;

trait TestKeys
{
    use Backtrace;

    protected $trans_prefix = null;

    protected $items = [];

    protected function trans(string $key, ?string $locale = null): string
    {
        $key = $this->trans_prefix . $key;

        return __($key, [], $locale);
    }

    protected function testSame(string $expected, string $key, ?string $locale = null): void
    {
        $message = $this->getTestMessage($key, $locale);

        $this->assertSame($expected, $this->trans($key, $locale), $message);
    }

    protected function getTestMessage(string $key, ?string $locale = null): string
    {
        $method = $this->getCalledMethod();

        return sprintf('%s::%s(%s): %s%s', static::class, $method, $locale, $this->trans_prefix, $key);
    }
}
