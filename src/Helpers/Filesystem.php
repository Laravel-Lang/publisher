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

use LaravelLang\Publisher\Exceptions\UnreadableFileException;
use Throwable;

/** The few filesystem operations the publisher needs, built on native PHP only. */
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

    /** @throws UnreadableFileException */
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

    /** @return string the real path of the stored file */
    public static function store(string $path, string $content, int $mode = 0o755): string
    {
        self::ensureDirectory(dirname($path), $mode);

        file_put_contents($path, $content);

        return realpath($path);
    }
}
