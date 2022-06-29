# Facades

Perhaps the facades will be useful to you:

## Locales

```php
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;

// List of available localizations.
Locales::available(): array

// List of installed localizations.
Locales::installed(): array

// List of installed localizations without protected codes.
Locales::installedWithoutProtects(): array

// List of uninstalled localizations.
Locales::notInstalled(): array

// Retrieving a list of protected locales.
Locales::protects(): array

// Checks if a language pack is installed.
Locales::isAvailable(LocaleCode|string|null $locale): bool

// Checks whether it is possible to install the language pack.
Locales::isInstalled(LocaleCode|string|null $locale): bool

// The checked locale protecting.
Locales::isProtected(LocaleCode|string|null $locale): bool

// Getting the default localization name.
Locales::getDefault(): string

// Getting the fallback localization name.
Locales::getFallback(): string
```
