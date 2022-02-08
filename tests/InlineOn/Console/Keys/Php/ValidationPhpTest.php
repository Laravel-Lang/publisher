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

namespace Tests\InlineOn\Console\Keys\Php;

use Tests\InlineOn\Console\Keys\BasePhpTestCase;

class ValidationPhpTest extends BasePhpTestCase
{
    protected $trans_prefix = 'validation.';

    protected $items = [
        'accepted'        => ['This field must be accepted.', 'Должно быть принято.'],
        'accepted_if'     => ['This field must be accepted when :other is :value.', 'Должно быть принято, когда :other соответствует :value.'],
        'active_url'      => ['This is not a valid URL.', 'Недействительный URL.'],
        'after'           => ['This must be a date after :date.', 'Дата должна быть после :date.'],
        'after_or_equal'  => ['This must be a date after or equal to :date.', 'Дата должна быть после или равной :date.'],
        'alpha'           => ['This field must only contain letters.', 'Здесь могут быть только буквы.'],
        'alpha_num'       => ['This field must only contain letters and numbers.', 'Здесь могут быть только буквы и цифры.'],
        'array'           => ['This field must be an array.', 'Здесь должен быть массив.'],
        'between.array'   => ['This content must have between :min and :max items.', 'Количество элементов должно быть между :min и :max.'],
        'between.file'    => ['This file must be between :min and :max kilobytes.', 'Размер файла должен быть между :min и :max Килобайт(а).'],
        'between.numeric' => ['This value must be between :min and :max.', 'Значение должно быть между :min и :max.'],
        'between.string'  => ['This string must be between :min and :max characters.', 'Количество символов должно быть между :min и :max.'],
    ];
}
