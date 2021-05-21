<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Contracts\Plugin;
use Helldar\LaravelLangPublisher\Facades\Config;

trait Plugins
{
    protected $plugins;

    /**
     * @return array|\Helldar\LaravelLangPublisher\Plugins\Plugin[]
     */
    protected function plugins(): array
    {
        if (! empty($this->plugins)) {
            return $this->plugins;
        }

        $plugins = array_map(static function ($plugin) {
            /* @var \Helldar\LaravelLangPublisher\Plugins\Plugin $plugin */
            return $plugin::make();
        }, $this->getPlugins());

        $plugins = array_filter($plugins, static function (Plugin $plugin) {
            return $plugin->has();
        });

        return $this->plugins = $plugins;
    }

    protected function getPlugins(): array
    {
        $this->log('Getting a list of plugins...');

        return Config::plugins();
    }
}
