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

class FortifyJsonTest extends BaseJsonTestCase
{
    protected $items = [
        'The :attribute must be at least :length characters and contain at least one number.' =>
            'Значение поля :attribute должно быть не меньше :length символов и содержать как минимум одну цифру.',

        'The provided password was incorrect.' =>
            'Неверный пароль.',

        'The provided two factor authentication code was invalid.' =>
            'Неверный код двухфакторной аутентификации.',
    ];
}
