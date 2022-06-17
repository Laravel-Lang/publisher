<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Resources;

use DragonCode\Contracts\LangPublisher\Translation as Resource;
use DragonCode\Support\Concerns\Makeable;

/**
 * @method Resource make()
 */
class Translation implements Resource
{
    use Makeable;

    protected array $keys = [];

    protected array $translations = [];

    public function keys(string $target, array $keys): Resource
    {
        $values = $this->keys[$target] ?? [];

        $this->keys[$target] = array_merge($values, $keys);

        return $this;
    }

    public function translation(string $locale, string $target, array $translations): Resource
    {
        $values = $this->translations[$locale][$target] ?? [];

        $this->translations[$locale][$target] = array_merge($values, $translations);

        return $this;
    }

    public function getKeys(): array
    {
        return $this->keys;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }
}
