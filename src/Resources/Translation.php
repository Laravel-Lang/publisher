<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2022 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Resources;

use DragonCode\Contracts\Support\Arrayable;
use DragonCode\Support\Facades\Helpers\Str;

class Translation implements Arrayable
{
    protected array $source = [];

    protected array $translations = [];

    public function setSource(string $filename, array $values): self
    {
        $this->source[$filename] = array_merge($this->source[$filename] ?? [], $values);

        return $this;
    }

    public function setTranslations(string $locale, array $values): self
    {
        $this->translations[$locale] = array_merge($this->translations[$locale] ?? [], $values);

        return $this;
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->source as $filename => $keys) {
            foreach ($this->translations as $locale => $values) {
                $name = $this->resolveFilename($filename, $locale);

                $result[$name] = array_merge($keys, array_intersect_key($values, $keys));
            }
        }

        return $result;
    }

    protected function resolveFilename(string $path, string $locale): string
    {
        return Str::replaceFormat($path, compact('locale'), '{%s}');
    }
}
