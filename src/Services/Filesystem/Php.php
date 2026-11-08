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

use Illuminate\Support\Arr as IlluminateArr;
use LaravelLang\Publisher\Helpers\Filesystem;

class Php extends Base
{
    protected array $except_keys = ['custom.attribute-name.rule-name'];

    public function load(string $path): array
    {
        $items = IlluminateArr::except(
            IlluminateArr::dot(parent::load($path)),
            $this->except_keys
        );

        // Drop empty values, but keep booleans: `false` is a meaningful translation value.
        return array_filter($items, static fn ($value) => ! empty($value) || is_bool($value));
    }

    public function store(string $path, $content): string
    {
        $content = $this->sort($content);

        $content = $this->hasValidation($path)
            ? $this->expandValidation($content)
            : $this->expand($content);

        Filesystem::store($path, $this->formatter->file($content));

        return $path;
    }

    protected function expand(array $values): array
    {
        $result = [];

        foreach ($values as $key => $value) {
            IlluminateArr::set($result, $key, $value);
        }

        return $result;
    }

    protected function expandValidation(array $values): array
    {
        $attributes = [];
        $items      = [];

        foreach ($values as $key => $value) {
            if (str_starts_with((string) $key, 'attributes.')) {
                $attributeKey              = explode('.', $key, 2)[1];
                $attributes[$attributeKey] = $value;

                continue;
            }

            IlluminateArr::set($items, $key, $value);
        }

        $custom = IlluminateArr::get($items, 'custom');

        $result = IlluminateArr::except($items, ['attributes', 'custom']);

        // They go last, in this order, regardless of where they appeared in the source.
        if (! empty($attributes)) {
            $result['attributes'] = $attributes;
        }

        if (! empty($custom)) {
            $result['custom'] = $custom;
        }

        return $result;
    }
}
