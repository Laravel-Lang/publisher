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

namespace Helldar\LaravelLangPublisher\Resources;

use Helldar\Contracts\LangPublisher\Translation as Resource;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;

class Translation implements Resource
{
    use Makeable;

    protected $keys = [];

    protected $translations = [];

    public function getKeys(): array
    {
        return $this->keys;
    }

    public function keys(string $target, array $keys): Resource
    {
        $values = $this->keys[$target] ?? [];

        $this->keys[$target] = $this->merge($keys, $values);

        return $this;
    }

    public function translation(string $locale, string $target, array $translations): Resource
    {
        $values = $this->translations[$target][$locale] ?? [];

        $this->translations[$target][$locale] = $this->merge($translations, $values);

        return $this;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }

    protected function merge(array ...$arrays): array
    {
        return Arr::merge(...$arrays);
    }
}
