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

namespace LaravelLang\Publisher\Services\Filesystem;

use DragonCode\PrettyArray\Services\File;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Helpers\Ables\Arrayable;
use Illuminate\Support\Arr as IlluminateArr;

class Php extends Base
{
    protected array $except_keys = ['custom.attribute-name.rule-name'];

    public function load(string $path): array
    {
        return Arr::of(parent::load($path))
            ->flattenKeys()
            ->except($this->except_keys)
            ->filter()
            ->toArray();
    }

    public function store(string $path, $content): string
    {
        $content = $this->sort($content);

        $content = $this->expand($content);

        if ($this->hasValidation($path)) {
            $content = $this->validationSort($content);
        }

        $content = $this->format($content);

        File::make($content)->store($path);

        return $path;
    }

    protected function format(array $items): string
    {
        if ($this->config->hasAlign()) {
            $this->formatter->setEqualsAlign();
        }

        return $this->formatter->raw($items);
    }

    protected function expand(array $values): array
    {
        $result = [];

        foreach ($values as $key => $value) {
            IlluminateArr::set($result, $key, $value);
        }

        return $result;
    }

    protected function validationSort(array $items): array
    {
        $attributes = Arr::get($items, 'attributes');
        $custom     = Arr::get($items, 'custom');

        return Arr::of($items)
            ->when(! empty($attributes), static fn (Arrayable $array) => $array->except('attributes')->set('attributes', $attributes))
            ->when(! empty($custom), static fn (Arrayable $array) => $array->except('custom')->set('custom', $custom))
            ->toArray();
    }
}
