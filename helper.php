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

if (! function_exists('lang_path')) {
    function lang_path(string $path = ''): string
    {
        $directory = is_dir(base_path('resources/lang'))
            ? base_path('resources/lang')
            : base_path('lang');

        return $directory . (! empty($path) ? DIRECTORY_SEPARATOR . $path : '');
    }
}
