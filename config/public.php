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

use Helldar\PrettyArray\Contracts\Caseable;

return [
    /*
     * Determines what type of files to use when updating language files.
     *
     * `true` means inline files will be used.
     * `false` means that default files will be used.
     *
     * The difference between them can be seen here:
     * @see https://github.com/Laravel-Lang/lang/blob/master/script/en/validation.php
     * @see https://github.com/Laravel-Lang/lang/blob/master/script/en/validation-inline.php
     *
     * By default, `true`.
     */

    'inline' => true,

    /*
     * Do arrays need to be aligned by keys before processing arrays?
     *
     * By default, true
     */

    'alignment' => true,

    /*
     * Key exclusion when combining.
     */

    'excludes' => [
        // 'auth' => ['throttle'],
        // 'pagination' => ['previous'],
        // 'passwords' => ['reset', 'throttled', 'user'],
        // '{locale}' => ['Confirm Password'],
    ],

    /*
     * Change key case.
     *
     * Available values:
     *
     *   Helldar\PrettyArray\Contracts\Caseable::NO_CASE      - Case does not change
     *   Helldar\PrettyArray\Contracts\Caseable::CAMEL_CASE   - camelCase
     *   Helldar\PrettyArray\Contracts\Caseable::KEBAB_CASE   - kebab-case
     *   Helldar\PrettyArray\Contracts\Caseable::PASCAL_CASE  - PascalCase
     *   Helldar\PrettyArray\Contracts\Caseable::SNAKE_CASE   - snake_case
     *
     * By default, Caseable::NO_CASE
     */

    'case' => Caseable::NO_CASE,

    /*
     * Determines from which plugins to synchronize localization files.
     *
     * @see https://github.com/andrey-helldar/translations-template
     */

    'plugins' => [
        // \LaravelLang\Lang\Publisher\Provider::class,
        // \LaravelLang\HttpStatuses\Provider::class,
    ],
];
