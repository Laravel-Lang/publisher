<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Support\Arr as IlluminateArr;
use Illuminate\Support\Facades\Config as IlluminateConfig;

final class Config
{
    public const KEY = 'lang-publisher';

    public const KEY_PRIVATE = 'lang-publisher-private';

    /**
     * Getting a link to the folder with the source localization files.
     *
     * @return string
     */
    public function getVendorPath(): string
    {
        $path = IlluminateConfig::get(self::KEY_PRIVATE . '.vendor');

        return rtrim($path, '\\/');
    }

    /**
     * Getting the default localization name.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return IlluminateConfig::get('app.locale') ?: $this->getFallbackLocale();
    }

    /**
     * Getting the fallback localization name.
     *
     * @return string
     */
    public function getFallbackLocale(): string
    {
        return IlluminateConfig::get('app.fallback_locale', Locales::ENGLISH);
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
     * @param  bool  $is_json
     *
     * @return array
     */
    public function getExclude(string $key, array $default = [], bool $is_json = false): array
    {
        $exclude = $this->config('exclude', []);

        return $is_json
            ? $exclude
            : IlluminateArr::get($exclude, $key, $default);
    }

    public function getIgnore(): array
    {
        return $this->config('ignore', []);
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
