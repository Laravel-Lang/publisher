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

class ValidationPhpTest extends BasePhpTestCase
{
    protected $trans_prefix = 'validation.';

    protected $items = [
        'accepted'        => ['The :attribute must be accepted.', 'Вы должны принять :attribute.'],
        'accepted_if'     => ['The :attribute must be accepted when :other is :value.', 'Вы должны принять :attribute, когда :other соответствует :value.'],
        'active_url'      => ['The :attribute is not a valid URL.', 'Значение поля :attribute не является действительным URL.'],
        'after'           => ['The :attribute must be a date after :date.', 'Значение поля :attribute должно быть датой после :date.'],
        'after_or_equal'  => ['The :attribute must be a date after or equal to :date.', 'Значение поля :attribute должно быть датой после или равной :date.'],
        'alpha'           => ['The :attribute must only contain letters.', 'Значение поля :attribute может содержать только буквы.'],
        'alpha_num'       => ['The :attribute must only contain letters and numbers.', 'Значение поля :attribute может содержать только буквы и цифры.'],
        'array'           => ['The :attribute must be an array.', 'Значение поля :attribute должно быть массивом.'],
        'between.array'   => ['The :attribute must have between :min and :max items.', 'Количество элементов в поле :attribute должно быть между :min и :max.'],
        'between.file'    => ['The :attribute must be between :min and :max kilobytes.', 'Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).'],
        'between.numeric' => ['The :attribute must be between :min and :max.', 'Значение поля :attribute должно быть между :min и :max.'],
        'between.string'  => ['The :attribute must be between :min and :max characters.', 'Количество символов в поле :attribute должно быть между :min и :max.'],
    ];
}
