<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Exceptions;

use DragonCode\Contracts\LangPublisher\Plugin;
use RuntimeException;

class UnknownPluginInstanceException extends RuntimeException
{
    public function __construct(string $plugin)
    {
        $message = sprintf('The %s class is not a %s instance.', $plugin, Plugin::class);

        parent::__construct($message);
    }
}
