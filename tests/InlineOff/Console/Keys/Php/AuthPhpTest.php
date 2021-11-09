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

namespace Tests\InlineOff\Console\Keys\Php;

use Tests\InlineOff\Console\Keys\BasePhpTestCase;

class AuthPhpTest extends BasePhpTestCase
{
    protected $trans_prefix = 'auth.';

    protected $items = [
        'failed'   => ['These credentials do not match our records.', 'Неверное имя пользователя или пароль.'],
        'password' => ['The provided password is incorrect.', 'Неверный пароль.'],
        'throttle' => ['Too many login attempts. Please try again in :seconds seconds.', 'Слишком много попыток входа. Пожалуйста, попробуйте еще раз через :seconds секунд.'],
    ];
}
