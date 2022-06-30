<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2022 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
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
