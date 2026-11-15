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

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;
use LaravelLang\Publisher\Exceptions\UnreadableFileException;
use LaravelLang\Publisher\Helpers\Filesystem;
use PHPUnit\Framework\TestCase;

class FilesystemTest extends TestCase
{
    protected string $root;

    protected function setUp(): void
    {
        $this->root = sys_get_temp_dir() . '/publisher-fs-' . uniqid();

        Filesystem::ensureDirectory($this->root);
    }

    protected function tearDown(): void
    {
        (new IlluminateFilesystem)->deleteDirectory($this->root);
    }

    public function testStoreCreatesDirectoriesAndReturnsRealPath(): void
    {
        $path = Filesystem::store($this->root . '/new/deep/file.json', '[]');

        $this->assertSame(realpath($this->root . '/new/deep/file.json'), $path);
    }

    public function testLoad(): void
    {
        file_put_contents($this->root . '/a.json', '{"a":"b"}');
        file_put_contents($this->root . '/a.php', '<?php return ["c" => "d"];');

        $this->assertSame(['a' => 'b'], Filesystem::load($this->root . '/a.json'));
        $this->assertSame(['c' => 'd'], Filesystem::load($this->root . '/a.php'));
    }

    public function testLoadFailures(): void
    {
        file_put_contents($this->root . '/broken.json', '{nope');
        file_put_contents($this->root . '/a.txt', 'x');

        foreach (['broken.json', 'a.txt'] as $name) {
            try {
                Filesystem::load($this->root . '/' . $name);

                $this->fail("Expected an exception for $name");
            } catch (UnreadableFileException) {
                $this->addToAssertionCount(1);
            }
        }
    }
}
