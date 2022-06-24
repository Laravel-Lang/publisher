<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

return [
    'accepted'    => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url'  => 'The :attribute is not a valid URL.',

    'between' => [
        'array' => 'The :attribute must have between :min and :max items.',
        'file'  => 'The :attribute must be between :min and :max kilobytes.',
    ],

    'attributes' => [
        'first_name' => 'first name',
        'last_name'  => 'last name',
        'age'        => 'age',
    ],

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],

        'first_name' => [
            'required' => 'The :attribute field is required.',
            'string'   => 'The :attribute must be a string.',
        ],
    ],
];
