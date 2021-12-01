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
        'accepted'       => ['The :attribute must be accepted.', 'Вы должны принять :attribute.'],
        'accepted_if'    => ['The :attribute must be accepted when :other is :value.', 'Поле :attribute должно быть принято, когда :other соответствует :value.'],
        'active_url'     => ['The :attribute is not a valid URL.', 'Поле :attribute содержит недействительный URL.'],
        'after'          => ['The :attribute must be a date after :date.', 'В поле :attribute должна быть дата больше :date.'],
        'after_or_equal' => ['The :attribute must be a date after or equal to :date.', 'В поле :attribute должна быть дата больше или равняться :date.'],
        'alpha'          => ['The :attribute may only contain letters.', 'Поле :attribute может содержать только буквы.'],

        'alpha_dash' => [
            'The :attribute may only contain letters, numbers, dashes and underscores.',
            'Поле :attribute может содержать только буквы, цифры, дефис и нижнее подчеркивание.',
        ],

        'alpha_num'         => ['The :attribute may only contain letters and numbers.', 'Поле :attribute может содержать только буквы и цифры.'],
        'array'             => ['The :attribute must be an array.', 'Поле :attribute должно быть массивом.'],
        'attached'          => ['This :attribute is already attached.', 'Поле :attribute уже прикреплено.'],
        'before'            => ['The :attribute must be a date before :date.', 'В поле :attribute должна быть дата раньше :date.'],
        'before_or_equal'   => ['The :attribute must be a date before or equal to :date.', 'В поле :attribute должна быть дата раньше или равняться :date.'],
        'between.array'     => ['The :attribute must have between :min and :max items.', 'Количество элементов в поле :attribute должно быть между :min и :max.'],
        'between.file'      => ['The :attribute must be between :min and :max kilobytes.', 'Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).'],
        'between.numeric'   => ['The :attribute must be between :min and :max.', 'Значение поля :attribute должно быть между :min и :max.'],
        'between.string'    => ['The :attribute must be between :min and :max characters.', 'Количество символов в поле :attribute должно быть между :min и :max.'],
        'boolean'           => ['The :attribute field must be true or false.', 'Поле :attribute должно иметь значение логического типа.'],
        'confirmed'         => ['The :attribute confirmation does not match.', 'Поле :attribute не совпадает с подтверждением.'],
        'current_password'  => ['The password is incorrect.', 'Поле :attribute содержит некорректный пароль.'],
        'date'              => ['The :attribute is not a valid date.', 'Поле :attribute не является датой.'],
        'date_equals'       => ['The :attribute must be a date equal to :date.', 'Поле :attribute должно быть датой равной :date.'],
        'date_format'       => ['The :attribute does not match the format :format.', 'Поле :attribute не соответствует формату :format.'],
        'different'         => ['The :attribute and :other must be different.', 'Поля :attribute и :other должны различаться.'],
        'digits'            => ['The :attribute must be :digits digits.', 'Длина цифрового поля :attribute должна быть :digits.'],
        'digits_between'    => ['The :attribute must be between :min and :max digits.', 'Длина цифрового поля :attribute должна быть между :min и :max.'],
        'dimensions'        => ['The :attribute has invalid image dimensions.', 'Поле :attribute имеет недопустимые размеры изображения.'],
        'distinct'          => ['The :attribute field has a duplicate value.', 'Поле :attribute содержит повторяющееся значение.'],
        'email'             => ['The :attribute must be a valid email address.', 'Поле :attribute должно быть действительным электронным адресом.'],
        'ends_with'         => ['The :attribute must end with one of the following: :values.', 'Поле :attribute должно заканчиваться одним из следующих значений: :values'],
        'exists'            => ['The selected :attribute is invalid.', 'Выбранное значение для :attribute некорректно.'],
        'file'              => ['The :attribute must be a file.', 'Поле :attribute должно быть файлом.'],
        'filled'            => ['The :attribute field must have a value.', 'Поле :attribute обязательно для заполнения.'],
        'gt.array'          => ['The :attribute must have more than :value items.', 'Количество элементов в поле :attribute должно быть больше :value.'],
        'gt.file'           => ['The :attribute must be greater than :value kilobytes.', 'Размер файла в поле :attribute должен быть больше :value Килобайт(а).'],
        'gt.numeric'        => ['The :attribute must be greater than :value.', 'Значение поля :attribute должно быть больше :value.'],
        'gt.string'         => ['The :attribute must be greater than :value characters.', 'Количество символов в поле :attribute должно быть больше :value.'],
        'gte.array'         => ['The :attribute must have :value items or more.', 'Количество элементов в поле :attribute должно быть :value или больше.'],
        'gte.file'          => ['The :attribute must be greater than or equal to :value kilobytes.', 'Размер файла в поле :attribute должен быть :value Килобайт(а) или больше.'],
        'gte.numeric'       => ['The :attribute must be greater than or equal to :value.', 'Значение поля :attribute должно быть :value или больше.'],
        'gte.string'        => ['The :attribute must be greater than or equal to :value characters.', 'Количество символов в поле :attribute должно быть :value или больше.'],
        'image'             => ['The :attribute must be an image.', 'Поле :attribute должно быть изображением.'],
        'in'                => ['The selected :attribute is invalid.', 'Выбранное значение для :attribute ошибочно.'],
        'in_array'          => ['The :attribute field does not exist in :other.', 'Поле :attribute не существует в :other.'],
        'integer'           => ['The :attribute must be an integer.', 'Поле :attribute должно быть целым числом.'],
        'ip'                => ['The :attribute must be a valid IP address.', 'Поле :attribute должно быть действительным IP-адресом.'],
        'ipv4'              => ['The :attribute must be a valid IPv4 address.', 'Поле :attribute должно быть действительным IPv4-адресом.'],
        'ipv6'              => ['The :attribute must be a valid IPv6 address.', 'Поле :attribute должно быть действительным IPv6-адресом.'],
        'json'              => ['The :attribute must be a valid JSON string.', 'Поле :attribute должно быть JSON строкой.'],
        'lt.array'          => ['The :attribute must have less than :value items.', 'Количество элементов в поле :attribute должно быть меньше :value.'],
        'lt.file'           => ['The :attribute must be less than :value kilobytes.', 'Размер файла в поле :attribute должен быть меньше :value Килобайт(а).'],
        'lt.numeric'        => ['The :attribute must be less than :value.', 'Значение поля :attribute должно быть меньше :value.'],
        'lt.string'         => ['The :attribute must be less than :value characters.', 'Количество символов в поле :attribute должно быть меньше :value.'],
        'lte.array'         => ['The :attribute must not have more than :value items.', 'Количество элементов в поле :attribute должно быть :value или меньше.'],
        'lte.file'          => ['The :attribute must be less than or equal to :value kilobytes.', 'Размер файла в поле :attribute должен быть :value Килобайт(а) или меньше.'],
        'lte.numeric'       => ['The :attribute must be less than or equal to :value.', 'Значение поля :attribute должно быть :value или меньше.'],
        'lte.string'        => ['The :attribute must be less than or equal to :value characters.', 'Количество символов в поле :attribute должно быть :value или меньше.'],
        'max.array'         => ['The :attribute may not have more than :max items.', 'Количество элементов в поле :attribute не может превышать :max.'],
        'max.file'          => ['The :attribute may not be greater than :max kilobytes.', 'Размер файла в поле :attribute не может быть больше :max Килобайт(а).'],
        'max.numeric'       => ['The :attribute may not be greater than :max.', 'Значение поля :attribute не может быть больше :max.'],
        'max.string'        => ['The :attribute may not be greater than :max characters.', 'Количество символов в поле :attribute не может превышать :max.'],
        'mimes'             => ['The :attribute must be a file of type: :values.', 'Поле :attribute должно быть файлом одного из следующих типов: :values.'],
        'mimetypes'         => ['The :attribute must be a file of type: :values.', 'Поле :attribute должно быть файлом одного из следующих типов: :values.'],
        'min.array'         => ['The :attribute must have at least :min items.', 'Количество элементов в поле :attribute должно быть не меньше :min.'],
        'min.file'          => ['The :attribute must be at least :min kilobytes.', 'Размер файла в поле :attribute должен быть не меньше :min Килобайт(а).'],
        'min.numeric'       => ['The :attribute must be at least :min.', 'Значение поля :attribute должно быть не меньше :min.'],
        'min.string'        => ['The :attribute must be at least :min characters.', 'Количество символов в поле :attribute должно быть не меньше :min.'],
        'multiple_of'       => ['The :attribute must be a multiple of :value', 'Значение поля :attribute должно быть кратным :value'],
        'not_in'            => ['The selected :attribute is invalid.', 'Выбранное значение для :attribute ошибочно.'],
        'not_regex'         => ['The :attribute format is invalid.', 'Выбранный формат для :attribute ошибочный.'],
        'numeric'           => ['The :attribute must be a number.', 'Поле :attribute должно быть числом.'],
        'password'          => ['The password is incorrect.', 'Неверный пароль.'],
        'present'           => ['The :attribute field must be present.', 'Поле :attribute должно присутствовать.'],
        'regex'             => ['The :attribute format is invalid.', 'Поле :attribute имеет ошибочный формат.'],
        'relatable'         => ['This :attribute may not be associated with this resource.', 'Поле :attribute не может быть связано с этим ресурсом.'],
        'required'          => ['The :attribute field is required.', 'Поле :attribute обязательно для заполнения.'],
        'required_if'       => ['The :attribute field is required when :other is :value.', 'Поле :attribute обязательно для заполнения, когда :other равно :value.'],
        'required_unless'   => ['The :attribute field is required unless :other is in :values.', 'Поле :attribute обязательно для заполнения, когда :other не равно :values.'],
        'required_with'     => ['The :attribute field is required when :values is present.', 'Поле :attribute обязательно для заполнения, когда :values указано.'],
        'required_with_all' => ['The :attribute field is required when :values are present.', 'Поле :attribute обязательно для заполнения, когда :values указано.'],
        'required_without'  => ['The :attribute field is required when :values is not present.', 'Поле :attribute обязательно для заполнения, когда :values не указано.'],

        'required_without_all' => [
            'The :attribute field is required when none of :values are present.',
            'Поле :attribute обязательно для заполнения, когда ни одно из :values не указано.',
        ],

        'prohibited'        => ['The :attribute field is prohibited.', 'Поле :attribute запрещено.'],
        'prohibited_if'     => ['The :attribute field is prohibited when :other is :value.', 'Поле :attribute запрещено, когда :other равно :value.'],
        'prohibited_unless' => ['The :attribute field is prohibited unless :other is in :values.', 'Поле :attribute запрещено, если :other не входит в :values.'],
        'prohibits'         => ['The :attribute field prohibits :other from being present.', 'Поле :attribute запрещает присутствие :other.'],
        'same'              => ['The :attribute and :other must match.', 'Значения полей :attribute и :other должны совпадать.'],
        'size.array'        => ['The :attribute must contain :size items.', 'Количество элементов в поле :attribute должно быть равным :size.'],
        'size.file'         => ['The :attribute must be :size kilobytes.', 'Размер файла в поле :attribute должен быть равен :size Килобайт(а).'],
        'size.numeric'      => ['The :attribute must be :size.', 'Значение поля :attribute должно быть равным :size.'],
        'size.string'       => ['The :attribute must be :size characters.', 'Количество символов в поле :attribute должно быть равным :size.'],
        'starts_with'       => ['The :attribute must start with one of the following: :values.', 'Поле :attribute должно начинаться из одного из следующих значений: :values'],
        'string'            => ['The :attribute must be a string.', 'Поле :attribute должно быть строкой.'],
        'timezone'          => ['The :attribute must be a valid timezone.', 'Поле :attribute должно быть действительным часовым поясом.'],
        'unique'            => ['The :attribute has already been taken.', 'Такое значение поля :attribute уже существует.'],
        'uploaded'          => ['The :attribute failed to upload.', 'Загрузка поля :attribute не удалась.'],
        'url'               => ['The :attribute must be a valid URL.', 'Поле :attribute имеет ошибочный формат URL.'],
        'uuid'              => ['The :attribute must be a valid UUID.', 'Поле :attribute должно быть корректным UUID.'],
    ];
}
