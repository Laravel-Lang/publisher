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
