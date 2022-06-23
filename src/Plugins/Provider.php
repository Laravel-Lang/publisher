<?php

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

    protected string $base_path;

    protected array $plugins;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->config = new Config();
    }

    public function register()
    {
        $this->set($this->basePath(), $this->plugins());
    }

    protected function plugins(): array
    {
        return Arr::of()
            ->tap(static fn (string $plugin) => Instance::of($plugin, Plugin::class) ? true : throw new UnknownPluginInstanceException($plugin))
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    protected function set(string $path, array $plugins): void
    {
        $this->config->setPrivate('plugins.' . $path, $plugins);
    }

    protected function basePath(): string
    {
        if ($path = realpath($this->base_path)) {
            return $path;
        }

        throw new RuntimeException(sprintf('The %s class must contain the definition of the $base_path property. The path must be existing.', static::class));
    }
}
