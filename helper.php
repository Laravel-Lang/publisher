<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

if (! function_exists('lang_path')) {
    function lang_path(string $path = ''): string
    {
        $directory = is_dir(base_path('resources/lang'))
            ? base_path('resources/lang')
            : base_path('lang');

        return $directory . (! empty($path) ? DIRECTORY_SEPARATOR . $path : '');
    }
}
