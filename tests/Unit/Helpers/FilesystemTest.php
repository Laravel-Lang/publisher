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

use LaravelLang\Publisher\Exceptions\UnreadableFileException;
use LaravelLang\Publisher\Helpers\Filesystem;
use PHPUnit\Framework\TestCase;

class FilesystemTest extends TestCase
{
    protected string $root;

    protected function setUp(): void
    {
        $this->root = sys_get_temp_dir() . '/publisher-fs-' . uniqid();

        Filesystem::store($this->root . '/de.json', '{}');
        Filesystem::store($this->root . '/de/validation.php', '<?php return [];');
        Filesystem::store($this->root . '/de/nested/auth.php', '<?php return [];');
        Filesystem::store($this->root . '/fr/auth.php', '<?php return [];');
    }

    protected function tearDown(): void
    {
        Filesystem::ensureDeleteDirectory($this->root);
    }

    public function testFilesAreRelativeAndSorted(): void
    {
        $this->assertSame(['de.json'], Filesystem::files($this->root));

        $this->assertSame(
            ['de.json', 'de/nested/auth.php', 'de/validation.php', 'fr/auth.php'],
            Filesystem::files($this->root, recursive: true)
        );
    }

    public function testDirectoriesAreRelativeAndSorted(): void
    {
        $this->assertSame(['de', 'fr'], Filesystem::directories($this->root));

        $this->assertSame(['de', 'de/nested', 'fr'], Filesystem::directories($this->root, recursive: true));
    }

    public function testFilterReceivesTheLexicalPath(): void
    {
        $this->assertSame(
            ['de/nested', 'fr'],
            Filesystem::directories(
                $this->root,
                static fn (string $path) => in_array(basename($path), ['nested', 'fr'], true),
                true
            )
        );
    }

    public function testEnsureDeleteDirectoryRemovesContentsAndIgnoresMissing(): void
    {
        Filesystem::ensureDeleteDirectory([$this->root . '/de', $this->root . '/missing']);

        $this->assertDirectoryDoesNotExist($this->root . '/de');
        $this->assertDirectoryExists($this->root . '/fr');
    }

    public function testDeletingASymlinkedDirectoryKeepsTheTarget(): void
    {
        $target = sys_get_temp_dir() . '/publisher-fs-target-' . uniqid();

        Filesystem::store($target . '/keep.php', '<?php return [];');
        symlink($target, $this->root . '/link');

        Filesystem::ensureDeleteDirectory($this->root . '/link');

        $this->assertFalse(is_link($this->root . '/link'));
        $this->assertFileExists($target . '/keep.php');

        Filesystem::ensureDeleteDirectory($target);
    }

    public function testSymlinkEntriesKeepTheirOwnNamesAndAreNotTraversed(): void
    {
        $target = sys_get_temp_dir() . '/publisher-fs-target-' . uniqid() . '/de';

        Filesystem::store($target . '/inner.php', '<?php return [];');
        symlink($target, $this->root . '/ext');
        symlink($this->root, $this->root . '/loop');
        symlink($this->root . '/de.json', $this->root . '/en.json');

        $this->assertSame(
            ['de', 'ext', 'fr', 'loop'],
            Filesystem::directories($this->root)
        );

        $this->assertSame(
            ['de.json', 'de/nested/auth.php', 'de/validation.php', 'en.json', 'fr/auth.php'],
            Filesystem::files($this->root, recursive: true)
        );

        Filesystem::ensureDeleteDirectory(dirname($target));
    }

    public function testFilterMatchesSymlinksByTheirOwnName(): void
    {
        symlink($this->root . '/de', $this->root . '/en');

        $byName = static fn (string $name) => static fn (string $path) => pathinfo($path, PATHINFO_FILENAME) === $name;

        $this->assertSame(['de'], Filesystem::directories($this->root, $byName('de')));
        $this->assertSame(['en'], Filesystem::directories($this->root, $byName('en')));
    }

    public function testEnsureDeleteFileIgnoresMissing(): void
    {
        Filesystem::ensureDeleteFile([$this->root . '/de.json', $this->root . '/missing.json']);

        $this->assertFileDoesNotExist($this->root . '/de.json');
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
