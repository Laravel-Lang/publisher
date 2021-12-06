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

namespace LaravelLang\Publisher\Concerns;

use DragonCode\Support\Facades\Helpers\Ables\Arrayable;
use Illuminate\Support\ServiceProvider;
use LaravelLang\Publisher\Facades\Helpers\Config;

abstract class BaseServiceProvider extends ServiceProvider
{
    abstract protected function getProvider(): string;

    public function register(): void
    {
        $this->registerProvider();
    }

    protected function registerProvider(): void
    {
        $config = $this->plugins();

        $plugins = $this->push($config);

        $this->setConfig($plugins);
    }

    protected function push(array $plugins): array
    {
        return Arrayable::of($plugins)
            ->push($this->getProvider())
            ->unique()
            ->sort()
            ->values()
            ->get();
    }

    protected function setConfig(array $plugins): void
    {
        config()->set($this->getConfigKey(), $plugins);
    }

    protected function plugins(): array
    {
        return config($this->getConfigKey(), []);
    }

    protected function getConfigKey(): string
    {
        return Config::privateKey('plugins');
    }
}
