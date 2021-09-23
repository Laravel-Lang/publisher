<?php

declare(strict_types=1);

namespace Helldar\Contracts\LangPublisher;

/**
 * @method static Translation make()
 */
interface Translation
{
    public function keys(string $target, array $keys): self;

    public function translation(string $locale, string $target, array $translations): self;

    public function getKeys(): array;

    public function getTranslations(): array;
}
