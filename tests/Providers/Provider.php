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

namespace Tests\Providers;

use LaravelLang\Lang\Provider as LaravelLang;

class Provider extends LaravelLang
{
    public function basePath(): string
    {
        return __DIR__ . '/../../vendor/laravel-lang/lang';
    }
}
