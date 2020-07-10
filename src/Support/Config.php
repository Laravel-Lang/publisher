<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Contracts\Config as ConfigContract;
use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Support\Facades\Config as IlluminateConfig;

final class Config implements ConfigContract
{
    /**
     * Getting a link to the folder with the source localization files.
     *
     * @return string
     */
    public function getVendorPath(): string
    {
        return realpath(__DIR__ . '/../../vendor/caouecs/laravel-lang/src');
    }

    /**
     * Getting the default localization name.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return IlluminateConfig::get('app.locale')
            ?: IlluminateConfig::get('app.fallback_locale', 'en');
    }

    /**
     * Getting the fallback localization name.
     *
     * @return string
     */
    public function getFallbackLocale(): string
    {
        return IlluminateConfig::get('app.fallback_locale', 'en');
    }

    /**
     * Will array alignment be applied.
     *
     * @return bool
     */
    public function isAlignment(): bool
    {
        return (bool) $this->config('alignment', true);
    }

    /**
     * Returns an array of exceptions set by the developer
     * when installing and updating localizations.
     *
     * @param  string  $key
     * @param  array  $default
     *
     * @return array
     */
    public function getExclude(string $key, array $default = []): array
    {
        $exclude = $this->config('exclude', []);

        return $exclude[$key] ?? $default;
    }

    /**
     * Returns the key mapping label.
     *
     * @return int
     */
    public function getCase(): int
    {
        return $this->config('case', Caseable::NO_CASE);
    }

    /**
     * Determines what type of files to use when updating language files.
     *
     * @return bool
     */
    public function isInline(): bool
    {
        return $this->config('inline', false);
    }

    protected function config(string $key, $default = null)
    {
        $key = $this->key($key);

        return IlluminateConfig::get($key, $default);
    }

    protected function key(string $key): string
    {
        return self::KEY . '.' . $key;
    }
}
