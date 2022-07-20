<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Plugins;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Instances\Instance;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelLang\Publisher\Exceptions\UnknownPluginInstanceException;
use LaravelLang\Publisher\Helpers\Config;
use RuntimeException;

abstract class Provider extends BaseServiceProvider
{
    protected Config $config;

    protected ?string $package_name = null;

    protected string $base_path;

    protected array $plugins;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->config = new Config();
    }

    public function register()
    {
        $this->registerPlugins();
        $this->registerPackageName();
    }

    protected function registerPlugins(): void
    {
        $this->config->setPlugins(
            $this->basePath(),
            $this->plugins()
        );
    }

    protected function registerPackageName(): void
    {
        if ($name = $this->package_name) {
            $this->config->setPackage($name);
        }
    }

    protected function plugins(): array
    {
        return Arr::of($this->plugins)
            ->tap(static fn (string $plugin) => Instance::of($plugin, Plugin::class) ? true : throw new UnknownPluginInstanceException($plugin))
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    protected function basePath(): string
    {
        if ($path = realpath($this->base_path)) {
            return $path;
        }

        throw new RuntimeException(sprintf('The %s class must contain the definition of the $base_path property. The path must be existing.', static::class));
    }
}
