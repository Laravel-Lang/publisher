<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Resources;

use DragonCode\Contracts\LangPublisher\Translation as Resource;
use DragonCode\Support\Concerns\Makeable;
use LaravelLang\Publisher\Concerns\Arrayable;

class Translation implements Resource
{
    use Arrayable;
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

        $this->keys[$target] = $this->combine($values, $keys);

        return $this;
    }

    public function translation(string $locale, string $target, array $translations): Resource
    {
        $values = $this->translations[$target][$locale] ?? [];

        $this->translations[$target][$locale] = $this->mergeArray($values, $translations);

        return $this;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }
}
