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

namespace Tests\InlineOff\Console\Keys\Php;

use Tests\InlineOff\Console\Keys\BasePhpTestCase;

class PasswordsPhpTest extends BasePhpTestCase
{
    protected $trans_prefix = 'passwords.';

    protected $items = [
        'reset'     => ['Your password has been reset!', 'Ваш пароль был сброшен!'],
        'sent'      => ['We have emailed your password reset link!', 'Ссылка на сброс пароля была отправлена!'],
        'throttled' => ['Please wait before retrying.', 'Пожалуйста, подождите перед повторной попыткой.'],
    ];
}
