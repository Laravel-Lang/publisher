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

namespace Tests\InlineOff\Console\Keys\Json;

use Tests\InlineOff\Console\Keys\BaseJsonTestCase;

class FrameworkJsonTest extends BaseJsonTestCase
{
    protected $items = [
        'All rights reserved.' => 'Все права защищены.',

        'Forbidden' => 'Запрещено',
        'Go Home'   => 'Домой',

        'Go to page :page' => 'Перейти к :page-й странице',

        'Hello!' => 'Здравствуйте!',

        'Whoops!' => 'Упс!',
    ];
}
