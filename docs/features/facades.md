[Laravel Lang Publisher][link_source] / [Main Page](../index.md) / [Features](index.md) / Facades

# Facades

Perhaps the facades will be useful to you:

## Config

```php
use Helldar\LaravelLangPublisher\Facades\Config;

// Getting a list of packages from which to synchronize localization files.
Config::packages(): array

// Getting the default localization name.
Config::defaultLocale(): string


// Getting the fallback localization name.
Config::fallbackLocale(): string
```

## Locales

```php
use Helldar\LaravelLangPublisher\Facades\Locales;

// List of available locations.
Locales::available(bool $all = false): array

// List of installed locations.
Locales::installed(): array

// Retrieving a list of protected locales.
Locales::protects(): array

// Checks if a language pack is installed.
Locales::isAvailable(string $locale): bool

// The checked locale protecting.
Locales::isProtected(string $locale): bool

// Checks whether it is possible to install the language pack.
Locales::isInstalled(string $locale): bool

// Getting the default localization name.
Locales::getDefault(): string

// Getting the fallback localization name.
Locales::getFallback(): string
```

## Packages

```php
use Helldar\LaravelLangPublisher\Facades\Packages;

// Returns a sorted list of packages identified for processing.
Packages::get(): array
```

[link_source]:  https://github.com/andrey-helldar/laravel-lang-publisher
