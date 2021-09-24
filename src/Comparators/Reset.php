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

namespace Helldar\LaravelLangPublisher\Comparators;

class Reset extends Base
{
    protected function merge(array $local, array $translated, array $excluded): array
    {
        return $this->sortAndMerge($local, $excluded, $translated);
    }

    protected function resource(string $filename, string $locale): array
    {
        return $this->full ? [] : parent::resource($filename, $locale);
    }
}
