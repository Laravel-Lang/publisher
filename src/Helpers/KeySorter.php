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

/**
 * Sorts translation keys the way they have always been written to disk:
 * case-insensitively, with keys made of a single symbol placed before
 * letters and digits.
 *
 * This is intentionally not a plain ksort(): changing the order would
 * rewrite every translation file published by existing installations.
 */
final class KeySorter
{
    /** Keys that are exactly one of these symbols sort before letters and digits. */
    protected const SPECIAL_CHARS = [
        ' ', '*', '-', '_', '—', '=', '\\', '/', '|', '~', '`', '+', ':', ';', '@', '#', '$', '%', '^', '&',
        '?', '!', '(', ')', '{', '}', '[', ']', '§', '№', '<', '>', '.', ',',
    ];

    public static function sort(array $items): array
    {
        uksort($items, self::compare(...));

        foreach ($items as &$value) {
            if (is_array($value)) {
                $value = self::sort($value);
            }
        }

        return $items;
    }

    protected static function compare(int|string $current, int|string $next): int
    {
        $current = is_string($current) ? mb_strtolower($current, 'UTF-8') : $current;
        $next    = is_string($next) ? mb_strtolower($next, 'UTF-8') : $next;

        if ($current === $next) {
            return 0;
        }

        if (is_string($current) && is_numeric($next)) {
            return self::isSpecial($current) ? -1 : 1;
        }

        if (is_numeric($current) && is_string($next)) {
            return self::isSpecial($next) ? 1 : -1;
        }

        return $current < $next ? -1 : 1;
    }

    protected static function isSpecial(string $value): bool
    {
        return in_array($value, self::SPECIAL_CHARS, true);
    }
}
