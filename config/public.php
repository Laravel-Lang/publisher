<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

use LaravelLang\Publisher\Constants\Locales;

return [
    /*
     * Determines what type of files to use when updating language files.
     *
     * `true` means inline files will be used.
     * `false` means that default files will be used.
     *
     * For example, the difference between them can be seen here:
     *
     * The :attribute must be accepted. // default
     * This field must be accepted.     // inline
     *
     * By default, `false`.
     */

    'inline' => false,

    /*
     * Do arrays need to be aligned by keys before processing arrays?
     *
     * By default, true
     */

    'align' => true,

    /*
     * This option determines the mechanism for converting translation
     * keys into a typographic version.
     *
     * For example:
     *   for `false`:
     *     "It's super-configurable... you can even use additional extensions to expand its capabilities -- just like this one!"
     *   for `true`:
     *     “It’s super-configurable… you can even use additional extensions to expand its capabilities – just like this one!”
     *
     * By default, false
     */

    'smart_punctuation' => [
        'enable' => false,

        'common' => [
            'double_quote_opener' => '“',
            'double_quote_closer' => '”',
            'single_quote_opener' => '‘',
            'single_quote_closer' => '’',
        ],

        'locales' => [
            Locales::FRENCH->value => [
                'double_quote_opener' => '«&nbsp;',
                'double_quote_closer' => '&nbsp;»',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],

            Locales::RUSSIAN->value => [
                'double_quote_opener' => '«',
                'double_quote_closer' => '»',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],

            Locales::UKRAINIAN->value => [
                'double_quote_opener' => '«',
                'double_quote_closer' => '»',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],

            Locales::BELARUSIAN->value => [
                'double_quote_opener' => '«',
                'double_quote_closer' => '»',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],
        ],
    ],

    /*
     * The language codes chosen for the files in this repository may not
     * match the preferences for your project.
     *
     * Specify here mappings of localizations with your project.
     */

    'aliases' => [
        //\LaravelLang\Publisher\Constants\Locales::GERMAN->value => 'de-DE',
        //
        //\LaravelLang\Publisher\Constants\Locales::GERMAN_SWITZERLAND->value => 'de-CH',
    ],
];
