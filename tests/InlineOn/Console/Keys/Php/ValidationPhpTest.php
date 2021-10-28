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

namespace Tests\InlineOn\Console\Keys\Php;

use Tests\InlineOn\Console\Keys\BasePhpTestCase;

class ValidationPhpTest extends BasePhpTestCase
{
    protected $trans_prefix = 'validation.';

    protected $items = [
        'accepted'             => ['This field must be accepted.', 'Должно быть принято.'],
        'accepted_if'          => ['This field must be accepted when :other is :value.', 'Это поле должно быть принято, когда :other соответствует :value.'],
        'active_url'           => ['This is not a valid URL.', 'Недействительный URL.'],
        'after'                => ['This must be a date after :date.', 'Дата должна быть больше :date.'],
        'after_or_equal'       => ['This must be a date after or equal to :date.', 'Дата должна быть больше или равняться :date.'],
        'alpha'                => ['This field may only contain letters.', 'Здесь могут быть только буквы.'],
        'alpha_dash'           => ['This field may only contain letters, numbers, dashes and underscores.', 'Здесь могут быть только буквы, цифры, дефис и нижнее подчеркивание.'],
        'alpha_num'            => ['This field may only contain letters and numbers.', 'Здесь могут быть только буквы и цифры.'],
        'array'                => ['This field must be an array.', 'Здесь должен быть массив.'],
        'attached'             => ['This field is already attached.', 'Уже прикреплено.'],
        'before'               => ['This must be a date before :date.', 'Дата здесь должна быть раньше :date.'],
        'before_or_equal'      => ['This must be a date before or equal to :date.', 'Дата здесь должна быть раньше или равняться :date.'],
        'between.numeric'      => ['This value must be between :min and :max.', 'Количество элементов должно быть между :min и :max.'],
        'between.file'         => ['This file must be between :min and :max kilobytes.', 'Размер файла должен быть между :min и :max Килобайт(а).'],
        'between.string'       => ['This string must be between :min and :max characters.', 'Значение должно быть между :min и :max.'],
        'between.array'        => ['This content must have between :min and :max items.', 'Количество символов должно быть между :min и :max.'],
        'boolean'              => ['This field must be true or false.', 'Поле должно иметь значение логического типа.'],
        'confirmed'            => ['The confirmation does not match.', 'Не совпадает с подтверждением.'],
        'current_password'     => ['The password is incorrect.', 'Некорректный пароль.'],
        'date'                 => ['This is not a valid date.', 'Не является датой.'],
        'date_equals'          => ['This must be a date equal to :date.', 'Дата должна быть равной :date.'],
        'date_format'          => ['This does not match the format :format.', 'Не соответствует формату :format.'],
        'different'            => ['This value must be different from :other.', 'Значение должно отличаться от :other'],
        'digits'               => ['This must be :digits digits.', 'Длина должна быть :digits.'],
        'digits_between'       => ['This must be between :min and :max digits.', 'Длина должна быть между :min и :max.'],
        'dimensions'           => ['This image has invalid dimensions.', 'Изображение имеет недопустимые размеры.'],
        'distinct'             => ['This field has a duplicate value.', 'Поле содержит повторяющееся значение.'],
        'email'                => ['This must be a valid email address.', 'Электронный адрес должен быть действительным.'],
        'ends_with'            => ['This must end with one of the following: :values.', 'Должно заканчиваться одним из следующих значений: :values'],
        'exists'               => ['The selected value is invalid.', 'Выбранное значение некорректно.'],
        'file'                 => ['The content must be a file.', 'Содержимое должно быть файлом.'],
        'filled'               => ['This field must have a value.', 'Обязательно для заполнения.'],
        'gt.numeric'           => ['The value must be greater than :value.', 'Количество элементов должно быть больше :value.'],
        'gt.file'              => ['The file size must be greater than :value kilobytes.', 'Размер файла должен быть больше :value Килобайт(а).'],
        'gt.string'            => ['The string must be greater than :value characters.', 'Значение должно быть больше :value.'],
        'gt.array'             => ['The content must have more than :value items.', 'Количество символов должно быть больше :value.'],
        'gte.numeric'          => ['The value must be greater than or equal :value.', 'Количество элементов должно быть :value или больше.'],
        'gte.file'             => ['The file size must be greater than or equal :value kilobytes.', 'Размер файла должен быть :value Килобайт(а) или больше.'],
        'gte.string'           => ['The string must be greater than or equal :value characters.', 'Значение должно быть :value или больше.'],
        'gte.array'            => ['The content must have :value items or more.', 'Количество символов должно быть :value или больше.'],
        'image'                => ['This must be an image.', 'Здесь должно быть изображение.'],
        'in'                   => ['The selected value is invalid.', 'Выбранное значение ошибочно.'],
        'in_array'             => ['This value does not exist in :other.', 'Значение не существует в :other.'],
        'integer'              => ['This must be an integer.', 'Должно быть целое число.'],
        'ip'                   => ['This must be a valid IP address.', 'Должен быть действительный IP-адрес.'],
        'ipv4'                 => ['This must be a valid IPv4 address.', 'Должен быть действительный IPv4-адрес.'],
        'ipv6'                 => ['This must be a valid IPv6 address.', 'Должен быть действительный IPv6-адрес.'],
        'json'                 => ['This must be a valid JSON string.', 'Должно быть JSON строкой.'],
        'lt.numeric'           => ['The value must be less than :value.', 'Количество элементов должно быть меньше :value.'],
        'lt.file'              => ['The file size must be less than :value kilobytes.', 'Размер файла должен быть меньше :value Килобайт(а).'],
        'lt.string'            => ['The string must be less than :value characters.', 'Значение должно быть меньше :value.'],
        'lt.array'             => ['The content must have less than :value items.', 'Количество символов должно быть меньше :value.'],
        'lte.numeric'          => ['The value must be less than or equal :value.', 'Количество элементов должно быть :value или меньше.'],
        'lte.file'             => ['The file size must be less than or equal :value kilobytes.', 'Размер файла должен быть :value Килобайт(а) или меньше.'],
        'lte.string'           => ['The string must be less than or equal :value characters.', 'Значение должно быть :value или меньше.'],
        'lte.array'            => ['The content must not have more than :value items.', 'Количество символов должно быть :value или меньше.'],
        'max.numeric'          => ['The value may not be greater than :max.', 'Количество элементов не может превышать :max.'],
        'max.file'             => ['The file size may not be greater than :max kilobytes.', 'Размер файла не может быть больше :max Килобайт(а).'],
        'max.string'           => ['The string may not be greater than :max characters.', 'Значение не может быть больше :max.'],
        'max.array'            => ['The content may not have more than :max items.', 'Количество символов не может превышать :max.'],
        'mimes'                => ['This must be a file of type: :values.', 'Должен быть файл одного из следующих типов: :values.'],
        'mimetypes'            => ['This must be a file of type: :values.', 'Должен быть файл одного из следующих типов: :values.'],
        'min.numeric'          => ['The value must be at least :min.', 'Количество элементов должно быть не меньше :min.'],
        'min.file'             => ['The file size must be at least :min kilobytes.', 'Размер файла должен быть не меньше :min Килобайт(а).'],
        'min.string'           => ['The string must be at least :min characters.', 'Значение должно быть не меньше :min.'],
        'min.array'            => ['The value must have at least :min items.', 'Количество символов должно быть не меньше :min.'],
        'multiple_of'          => ['The value must be a multiple of :value', 'Значение должно быть кратным :value'],
        'not_in'               => ['The selected value is invalid.', 'Выбранное значение ошибочно.'],
        'not_regex'            => ['This format is invalid.', 'Выбранный формат ошибочный.'],
        'numeric'              => ['This must be a number.', 'Здесь должно быть число.'],
        'password'             => ['The password is incorrect.', 'Неверный пароль.'],
        'present'              => ['This field must be present.', 'Значение должно быть.'],
        'regex'                => ['This format is invalid.', 'Данное значение запрещено.'],
        'relatable'            => ['This field may not be associated with this resource.', 'Значение запрещено, когда :other равно :value.'],
        'required'             => ['This field is required.', 'Значение запрещено, если :other не входит в :values.'],
        'required_if'          => ['This field is required when :other is :value.', 'Запрещено присутствие :other.'],
        'required_unless'      => ['This field is required unless :other is in :values.', 'Ошибочный формат.'],
        'required_with'        => ['This field is required when :values is present.', 'Объект не может быть связан с этим ресурсом.'],
        'required_with_all'    => ['This field is required when :values are present.', 'Обязательно для заполнения.'],
        'required_without'     => ['This field is required when :values is not present.', 'Обязательно для заполнения, когда :other равно :value.'],
        'required_without_all' => ['This field is required when none of :values are present.', 'Обязательно для заполнения, когда :other не равно :values.'],
        'prohibited'           => ['This field is prohibited.', 'Обязательно для заполнения, когда :values указано.'],
        'prohibited_if'        => ['This field is prohibited when :other is :value.', 'Обязательно для заполнения, когда :values указано.'],
        'prohibited_unless'    => ['This field is prohibited unless :other is in :values.', 'Обязательно для заполнения, когда :values не указано.'],
        'prohibits'            => ['This field prohibits :other from being present.', 'Обязательно для заполнения, когда ни одно из :values не указано.'],
        'same'                 => ['The value of this field must match the one from :other.', 'Значение должно совпадать с :other.'],
        'size.numeric'         => ['The value must be :size.', 'Количество элементов должно быть равным :size.'],
        'size.file'            => ['The file size must be :size kilobytes.', 'Размер файла должен быть равен :size Килобайт(а).'],
        'size.string'          => ['The string must be :size characters.', 'Значение должно быть равным :size.'],
        'size.array'           => ['The content must contain :size items.', 'Количество символов должно быть равным :size.'],
        'starts_with'          => ['This must start with one of the following: :values.', 'Значение должно начинаться из одного из следующих значений: :values'],
        'string'               => ['This must be a string.', 'Здесь должна быть строка.'],
        'timezone'             => ['This must be a valid timezone.', 'Должен быть действительный часовой пояс.'],
        'unique'               => ['This has already been taken.', 'Такое значение уже существует.'],
        'uploaded'             => ['This failed to upload.', 'Загрузка не удалась.'],
        'url'                  => ['This must be a valid URL.', 'Ошибочный формат URL.'],
        'uuid'                 => ['This must be a valid UUID.', 'Должен быть корректный UUID.'],
    ];
}
