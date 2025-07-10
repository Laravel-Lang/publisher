<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
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

        'timeplan'            => 'Timeplan',
        'timeplan.monday'     => 'Monday',
        'timeplan.monday.0.0' => 'Monday (from)',
        'timeplan.monday.0.1' => 'Monday (to)',
        'timeplan.monday.1.0' => 'Monday (from)',
        'timeplan.monday.1.1' => 'Monday (to)',

        // manually adding arrays works, but will be flattened in update process
        'list' => [
            'jobs'      => 'List of jobs',
            'vehicles'  => 'List of vehicles',
        ]
    ],

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],

        'first_name' => [
            'required' => 'First name is required.',
            'string'   => 'First name must be a string.',
        ],
    ],
];
