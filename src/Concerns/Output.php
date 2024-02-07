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

namespace LaravelLang\Publisher\Concerns;

use Illuminate\Console\View\Components\Factory;

trait Output
{
    protected ?Factory $components = null;

    protected function info(string $message): void
    {
        $this->emptyLine();

        $this->componentFactory()->info($message);
    }

    protected function task(string $message, callable $callback): void
    {
        $this->componentFactory()->task($message, $callback);
    }

    protected function emptyLine(): void
    {
        $this->output->newLine();
    }

    protected function componentFactory(): Factory
    {
        if (! empty($this->components)) {
            return $this->components;
        }

        return $this->components = new Factory($this->output);
    }
}
