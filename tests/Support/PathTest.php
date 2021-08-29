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

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Support\Path;
use Tests\TestCase;

class PathTest extends TestCase
{
    public function testExtension()
    {
        $this->assertSame('php', $this->resolve()->extension('foo.php'));
        $this->assertSame('php', $this->resolve()->extension('foo/bar/baz.php'));

        $this->assertSame('json', $this->resolve()->extension('foo.json'));
        $this->assertSame('json', $this->resolve()->extension('foo/bar/baz.json'));
    }

    public function testBasename()
    {
        $this->assertSame('foo.php', $this->resolve()->basename('foo.php'));
        $this->assertSame('baz.php', $this->resolve()->basename('foo/bar/baz.php'));

        $this->assertSame('foo.json', $this->resolve()->basename('foo.json'));
        $this->assertSame('baz.json', $this->resolve()->basename('foo/bar/baz.json'));
    }

    public function testFilename()
    {
        $this->assertSame('foo', $this->resolve()->filename('foo.php'));
        $this->assertSame('baz', $this->resolve()->filename('foo/bar/baz.php'));

        $this->assertSame('foo', $this->resolve()->filename('foo.json'));
        $this->assertSame('baz', $this->resolve()->filename('foo/bar/baz.json'));
    }

    public function testVendor()
    {
        $path = realpath(__DIR__ . '/../../vendor');

        $this->assertSame($path . '/foo.php', $this->resolve()->vendor('foo.php'));
        $this->assertSame($path . '/foo/bar/baz.php', $this->resolve()->vendor('foo/bar/baz.php'));

        $this->assertSame($path . '/foo.json', $this->resolve()->vendor('foo.json'));
        $this->assertSame($path . '/foo/bar/baz.json', $this->resolve()->vendor('foo/bar/baz.json'));
    }

    protected function resolve(): Path
    {
        return new Path();
    }
}