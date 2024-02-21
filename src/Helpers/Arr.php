<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Helpers;

use DragonCode\Support\Facades\Helpers\Arr as DragonArr;

class Arr
{
    public function merge(array $source, array $target, bool $filter_keys = false): array
    {
        foreach ($this->filter($source, $target, $filter_keys) as $key => $value) {
            if (! empty($value)) {
                $source[$key] = $value;
            }
        }

        return $source;
    }

    protected function filter(array $source, array $target, bool $filter_keys = false): array
    {
        return $filter_keys ? DragonArr::only($target, DragonArr::keys($source)) : $target;
    }

    public function ksort(array $source): array
    {
        ksort($source);

        foreach ($source as $key => &$value) {
            if (is_array($value)) {
                $value = $this->ksort($value);
            }
        }

        return $source;
    }
}
