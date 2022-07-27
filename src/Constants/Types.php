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

namespace LaravelLang\Publisher\Constants;

enum Types: string
{
    case TYPE_CLASS = 'class';

    case TYPE_NAME = 'name';
}
