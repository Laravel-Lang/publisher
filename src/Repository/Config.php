<?php

namespace Helldar\LaravelLangPublisher\Repository;

use Helldar\LaravelLangPublisher\Contracts\Config as ConfigContract;
use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Foundation\Application;

class Config implements ConfigContract
{
    protected $vendor;

    protected $alignment;

    protected $exclude;

    protected $case;

    public function __construct(Application $app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $this->vendor    = $config->get('lang-publisher.vendor', \base_path('vendor/caouecs/laravel-lang/src'));
        $this->alignment = $config->get('lang-publisher.alignment', true);
        $this->exclude   = $config->get('lang-publisher.exclude', []);
        $this->case      = $config->get('lang-publisher.case', Caseable::NO_CASE);
    }

    public function getVendorPath(): string
    {
        return $this->vendor;
    }

    public function isAlignment(): bool
    {
        return $this->alignment;
    }

    public function getExclude(string $key, array $default = []): array
    {
        return $this->exclude[$key] ?? $default;
    }

    public function getCase(): int
    {
        return $this->case;
    }
}
