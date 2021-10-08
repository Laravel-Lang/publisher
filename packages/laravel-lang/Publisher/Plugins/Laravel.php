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

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class Laravel extends BasePlugin
{
    public function vendor(): ?string
    {
        return 'laravel/framework';
    }

    public function files(): array
    {
        return [
            'auth.php'       => '{locale}/auth.php',
            'pagination.php' => '{locale}/pagination.php',
            'passwords.php'  => '{locale}/passwords.php',
            'validation.php' => '{locale}/validation.php',

            'validation-attributes.php' => '{locale}/validation.php',

            'packages/framework.json' => '{locale}.json',
        ];
    }
}
