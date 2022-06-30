<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Helpers;

use DragonCode\Support\Facades\Helpers\Arr;

class ArrayMerge
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
        return $filter_keys ? Arr::only($target, Arr::keys($source)) : $target;
    }
}
