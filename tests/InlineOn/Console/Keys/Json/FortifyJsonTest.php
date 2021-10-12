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

namespace Tests\InlineOn\Console\Keys\Json;

use Tests\InlineOn\Console\Keys\BaseJsonTestCase;

class FortifyJsonTest extends BaseJsonTestCase
{
    protected $items = [
        'The :attribute must be at least :length characters and contain at least one number.' =>
            'Поле :attribute должно быть не меньше :length символов и содержать как минимум одну цифру.',

        'The :attribute must be at least :length characters and contain at least one special character and one number.' =>
            'Поле :attribute должно быть не меньше :length символов, содержать как минимум один спецсимвол и одну цифру.',

        'The :attribute must be at least :length characters and contain at least one special character.' =>
            'Поле :attribute должно быть не меньше :length символов и содержать как минимум один спецсимвол.',

        'The :attribute must be at least :length characters and contain at least one uppercase character and one number.' =>
            'Поле :attribute должно быть не меньше :length символов и содержать как минимум один символ в верхнем регистре и одну цифру.',

        'The :attribute must be at least :length characters and contain at least one uppercase character and one special character.' =>
            'Поле :attribute должно быть не меньше :length символов и содержать как минимум один символ в верхнем регистре и один спецсимвол.',

        'The :attribute must be at least :length characters and contain at least one uppercase character, one number, and one special character.' =>
            'Поле :attribute должно быть не меньше :length символов и содержать как минимум один символ в верхнем регистре, одно число и один спецсимвол.',

        'The :attribute must be at least :length characters and contain at least one uppercase character.' =>
            'Поле :attribute должно быть не меньше :length символов и содержать как минимум один символ в верхнем регистре.',

        'The :attribute must be at least :length characters.' =>
            'Поле :attribute должно быть не меньше :length символов.',

        'The provided password does not match your current password.' =>
            'Указанный пароль не соответствует Вашему текущему паролю.',

        'The provided password was incorrect.' =>
            'Неверный пароль.',

        'The provided two factor authentication code was invalid.' =>
            'Неверный код двухфакторной аутентификации.',
    ];
}
