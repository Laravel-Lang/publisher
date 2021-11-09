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

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\Support\Facades\Helpers\Arr;

trait Arrayable
{
    protected function combine(array ...$arrays): array
    {
        return Arr::combine($arrays);
    }

    protected function mergeArray(array ...$arrays): array
    {
        return Arr::merge(...$arrays);
    }

    protected function sort(array $array): array
    {
        return Arr::ksort($array);
    }

    protected function sortAndMerge(array ...$arrays): array
    {
        $array = $this->mergeArray(...$arrays);

        return $this->sort($array);
    }
}
