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

namespace Tests\Main;

use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesConst;
use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Tests\TestCase;

class MissingTest extends TestCase
{
    use Paths;

    public function testMissing()
    {
        $const = $this->available();
        $lang  = $this->laravelLang();

        $missed = $this->diff($const, $lang);

        $message = 'Missed localizations: ' . $missed;

        $this->assertEmpty($missed, $message);
    }

    public function testExtra()
    {
        $const = $this->available();
        $lang  = $this->laravelLang();

        $extra = $this->diff($lang, $const);

        $message = 'Extra localizations: ' . $extra;

        $this->assertEmpty($extra, $message);
    }

    protected function available(): array
    {
        return Locales::available();
    }

    protected function laravelLang(): array
    {
        $vendor = $this->vendorPath('laravel-lang/lang/locales');

        $names = Directory::names($vendor);

        return Arrayable::of($names)
            ->addUnique(LocalesConst::ENGLISH)
            ->sort()
            ->values()
            ->get();
    }

    protected function diff(array $first, array $second): string
    {
        $array = array_diff($first, $second);

        return implode(', ', $array);
    }
}
