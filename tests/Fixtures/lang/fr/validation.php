<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

return [
    'accepted'    => 'Le champ :attribute doit être accepté.',
    'accepted_if' => 'Le champ :attribute doit être accepté quand :other a la valeur :value.',
    'active_url'  => 'Le champ :attribute n\'est pas une URL valide.',

    'between' => [
        'array' => 'Le tableau :attribute doit contenir entre :min et :max éléments.',
        'file'  => 'La taille du fichier de :attribute doit être comprise entre :min et :max kilo-octets.',
    ],

    'attributes' => [
        'first_name' => 'prénom',
        'last_name'  => 'nom',
        'age'        => 'âge',

        'timeplan.monday.0.0' => 'Lundi (de)',
        'timeplan.monday.0.1' => 'Lundi (à)',
        'timeplan.monday.1.0' => 'Lundi (de)',
        'timeplan.monday.1.1' => 'Lundi (à)',
    ],

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],

        'first_name' => [
            'required' => 'Le champ :attribute est obligatoire.',
            'string'   => 'Le champ :attribute doit être une chaîne de caractères.',
        ],
    ],
];
