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

namespace LaravelLang\Publisher\Services\Filesystem;

/**
 * Renders an array as a PHP short-array literal, one entry per line,
 * indented with four spaces per nesting level.
 *
 * The output is byte-for-byte what the previous third-party formatter
 * produced, quirks included, so that already published translation files
 * do not change. Do not "fix" those quirks here: they would show up as
 * diffs in every consumer's repository.
 */
final class PhpFormatter
{
    protected const INDENT = 4;

    public function __construct(
        protected bool $align = false
    ) {}

    /** A complete translation file: the declaration, the array and a trailing newline. */
    public function file(array $items): string
    {
        return "<?php\n\ndeclare(strict_types=1);\n\nreturn {$this->format($items)};\n";
    }

    public function format(array $items, int $level = 1): string
    {
        if ($items === []) {
            return '[]';
        }

        $indent = self::INDENT * $level;
        $width  = $this->keyWidth($items);

        $result = '[' . PHP_EOL;

        foreach ($items as $key => $value) {
            $result .= str_repeat(' ', $indent) . $this->key($key, $width) . ' => ' . $this->value($value, $level + 1) . ',' . PHP_EOL;
        }

        return $result . str_repeat(' ', $indent - self::INDENT) . ']';
    }

    /** Keys are always quoted, even numeric ones, and are not escaped. */
    protected function key(int|string $key, int $width): string
    {
        $key = "'$key'";

        return $this->align ? str_pad($key, $width) : $key;
    }

    /** Width of the longest key on this level, including the two quotes. */
    protected function keyWidth(array $items): int
    {
        return max(array_map(static fn ($key) => mb_strlen((string) $key), array_keys($items))) + 2;
    }

    protected function value(mixed $value, int $level): string
    {
        if (is_array($value) && $value !== []) {
            return $this->format($value, $level);
        }

        return $this->cast($value);
    }

    protected function cast(mixed $value): string
    {
        // Numeric strings are written as number literals, e.g. '123' becomes 123.
        if (is_numeric($value)) {
            return (string) $value;
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if ($value === null) {
            return 'null';
        }

        if (is_array($value)) {
            return '[]';
        }

        // stripslashes() first, so a single backslash in the source text is dropped.
        return "'" . str_replace(['\\', "'"], ['\\\\', "\\'"], stripslashes((string) $value)) . "'";
    }
}
