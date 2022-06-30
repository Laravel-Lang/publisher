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

namespace LaravelLang\Publisher\Concerns;

trait Output
{
    protected function info(string $message, string $style = 'fg=green'): void
    {
        $this->line($message, $style);
    }

    protected function line(string $message, ?string $style = null): void
    {
        $line = ! empty($style) ? sprintf('<%s>%s</>', $style, $message) : $message;

        $this->output->writeln($line);
    }
}
