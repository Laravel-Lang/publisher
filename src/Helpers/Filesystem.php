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

namespace LaravelLang\Publisher\Helpers;

use DirectoryIterator;
use LaravelLang\Publisher\Exceptions\UnreadableFileException;
use Throwable;

/**
 * The few filesystem operations the publisher needs, built on native PHP only.
 */
final class Filesystem
{
    public static function exists(string $path): bool
    {
        return is_file($path);
    }

    public static function ensureDirectory(string $path, int $mode = 0o755): void
    {
        if (! is_dir($path)) {
            mkdir($path, $mode, true);
        }
    }

    /** @param  array<string>|string  $paths */
    public static function ensureDeleteFile(array|string $paths): void
    {
        foreach ((array) $paths as $path) {
            if (is_file($path)) {
                unlink($path);
            }
        }
    }

    /**
     * Recursively delete directories. Symlinks are unlinked, never followed.
     *
     * @param  array<string>|string  $paths
     */
    public static function ensureDeleteDirectory(array|string $paths): void
    {
        foreach ((array) $paths as $path) {
            if (! is_dir($path)) {
                continue;
            }

            foreach (new DirectoryIterator($path) as $item) {
                if ($item->isDot()) {
                    continue;
                }

                $item->isDir() && ! $item->isLink()
                    ? self::ensureDeleteDirectory($item->getPathname())
                    : unlink($item->getPathname());
            }

            rmdir($path);
        }
    }

    /**
     * @throws UnreadableFileException
     */
    public static function load(string $path): array
    {
        try {
            $values = match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
                'php'   => require $path,
                'json'  => json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR),
                default => throw new UnreadableFileException($path),
            };
        } catch (UnreadableFileException $e) {
            throw $e;
        } catch (Throwable) {
            throw new UnreadableFileException($path);
        }

        return is_array($values) ? $values : throw new UnreadableFileException($path);
    }

    /**
     * @return string the real path of the stored file
     */
    public static function store(string $path, string $content, int $mode = 0o755): string
    {
        self::ensureDirectory(dirname($path), $mode);

        file_put_contents($path, $content);

        return realpath($path);
    }

    /**
     * Find files below $path.
     *
     * @param  callable(string): bool|null  $filter  receives the real path of each file
     *
     * @return array<string> paths relative to $path, sorted
     */
    public static function files(string $path, ?callable $filter = null, bool $recursive = false): array
    {
        return self::names($path, $filter, $recursive, false);
    }

    /**
     * Find directories below $path.
     *
     * @param  callable(string): bool|null  $filter  receives the real path of each directory
     *
     * @return array<string> paths relative to $path, sorted
     */
    public static function directories(string $path, ?callable $filter = null, bool $recursive = false): array
    {
        return self::names($path, $filter, $recursive, true);
    }

    protected static function names(string $path, ?callable $filter, bool $recursive, bool $directories): array
    {
        $root  = realpath($path);
        $paths = self::scan($root, $filter, $recursive, $directories);

        sort($paths);

        return array_map(
            static fn (string $item) => trim(substr($item, strlen($root)), '\\/'),
            $paths
        );
    }

    protected static function scan(string $path, ?callable $filter, bool $recursive, bool $directories): array
    {
        $items = [];

        foreach (new DirectoryIterator($path) as $item) {
            if ($item->isDot()) {
                continue;
            }

            $isMatch = $directories ? $item->isDir() : $item->isFile();

            if ($isMatch && (! $filter || $filter($item->getRealPath()))) {
                $items[] = $item->getRealPath();
            }

            if ($recursive && $item->isDir()) {
                $items = array_merge($items, self::scan($item->getRealPath(), $filter, $recursive, $directories));
            }
        }

        return $items;
    }
}
