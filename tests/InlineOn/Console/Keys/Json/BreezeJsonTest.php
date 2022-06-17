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

namespace Tests\InlineOn\Console\Keys\Json;

use Tests\InlineOn\Console\Keys\BaseJsonTestCase;

class BreezeJsonTest extends BaseJsonTestCase
{
    protected $items = [
        'Already registered?' => 'Уже зарегистрированы?',
        'Confirm'             => 'Подтвердить',
        'Confirm Password'    => 'Подтверждение пароля',
        'Dashboard'           => 'Главная',
        'Email'               => 'E-Mail адрес',

        'Whoops! Something went wrong.' => 'Упс! Что-то пошло не так.',
    ];
}
